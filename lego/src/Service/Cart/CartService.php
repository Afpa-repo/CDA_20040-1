<?php


namespace App\Service\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\Savecart;
use App\Repository\SavecartRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductsRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class CartService extends AbstractController
{
    protected $session;
    protected $productrepo;
    protected $manager;
    protected $user;
    protected $save;
    protected $mailer;



    public function __construct(SessionInterface $session, ProductsRepository $productrepo, EntityManagerInterface $manager, UserRepository $user, SavecartRepository $save ,MailerInterface $mailer)
    {
        $this->session = $session;
        $this->productrepo = $productrepo;
        $this->manager = $manager;
        $this->user = $user;
        $this->save = $save;
        $this->mailer = $mailer;

    }

    public function add(int $id)

    {

        $panier = $this->session->get('panier', []);

        if (isset($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function addsave()
    {
        $mail = $this->session->get('_security.last_username');
        $id = $this->user->findOneBy(['email'=>$mail])->getId();

        foreach($this->getCart() as $item)
        {
            if(isset($item['product']) || $item['user'] != $id)
            {
                $save = new Savecart();
                $save ->setIdproduct($item['product']->getId())
                    ->setIduser($id)
                    ->setQuantity($item['quantity'])
                    ->setTotal($item['product']->getPrice() * $item['quantity']);
                $this->manager->persist($save);
            }
            else
            {
                $recup = $this->save->findOneBy(['iduser'=>$id ,'idproduct' =>$item['product']->getId()]);

                if ($item['quantity'] != $recup->getQuantity())
                {
                    $recup->setQuantity($item['quantity']);
                }
                $this->manager->persist($recup);
            }
        }

        $this->manager->flush();

    }

    public function recupsave()
    {
        $mail = $this->session->get('_security.last_username');
        $id = $this->user->findOneBy(['email'=>$mail])->getId();
        $recup = $this->save->findBy(['iduser' =>$id]);


        foreach($recup as $item )
        {
            $this->add($item->getIdproduct());
            $this->manager->remove($item);
            $this->manager->flush();
        }

    }
    public function remove(int $id){

        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id] && $panier[$id].'quantity'>0))
        {
            $panier[$id]--;

            if($panier[$id].'quantity' <=0)

            {
                unset($panier[$id]);
            }

        }


        $this->session->set('panier', $panier);
    }
    public function getCart() :array {

        $panier = $this->session->get('panier', []);
        $panierRempli = [];

        foreach($panier as $id => $quantity)
        {
            $panierRempli[] = [

                'product'=> $this->productrepo->find($id),
                'quantity' => $quantity
            ];
        }

        return $panierRempli;
    }
    public function getTotal() :float {

        $total = 0;
        foreach($this->getCart() as $item)
        {
            $total +=$item['product']->getPrice() * $item['quantity'];
        }

        return $total;

    }

    public function deleteProduct(int $id) {


        $panier = $this->session->get('panier', []);
        if(!empty($panier[$id].'quantity'))
        {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);

    }

    public function createPDF( Order $order)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('PDF/pdf.html.twig', [
            'order'=>$order,'items'=>$this->getCart(),'total'=>$this->getTotal(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        $projectDir = $this->getParameter('kernel.project_dir');

        // e.g /var/www/project/public/mypdf.pdf
        $finalPath = $projectDir.join(DIRECTORY_SEPARATOR,['','public','PDF','']).'com'.$order->getId().'.pdf';

        // Write file to the desired path
        file_put_contents($finalPath, $output);

        // Send some text response
        return new Response("The PDF file has been succesfully generated !");

    }

    public function valider ()
    {
        $panier = $this->session->get('panier', []);
        $mail = $this->session->get('_security.last_username');
        $id = $this->user->findOneBy(['email'=>$mail])->getId();
        $user = $this->user->find($id);
        $projectDir = $this->getParameter('kernel.project_dir');



        if (!empty($panier)) {
            $order = new Order();
            $order->setDeliveryAdress('ex')
                ->setDeliveryDate(new \DateTime)
                ->setOrderDate(new \DateTime)
                ->setShippingPrice(25)
                ->setStatus("Valider");
            $this->manager->persist($order);
            $this->manager->flush();
            $this->createPDF($order);
            $finalPath = $projectDir . join(DIRECTORY_SEPARATOR, ['', 'public', 'PDF', '']) . 'com'.$order->getId().'.pdf';


            foreach ($this->getCart() as $item) {
                $od = new OrderDetails();
                $od->setProducts($item['product'])
                    ->setQuantity($item['quantity'])
                    ->setTotal($item['product']->getPrice() * $item['quantity'])
                    ->setOrders($order)
                    ->setUser($user);

                $this->manager->persist($od);
                $this->deleteProduct($item['product']->getid());
            }

            $this->manager->flush();


            $email = (new Email())
                ->from('hello@example.com')
                ->to($mail)
                ->attachFromPath($finalPath)
                ->subject('Lego : Facture commande n°'.$order->getId())
                ->text('Votre facture de la commande n°'.$order->getId());

            $this->mailer->send($email);



        }
    }
        public function numberItems()
    {

        $panier = $this->session->get('panier', []);
        if(!empty($panier)){

            return count($panier);
        }
    }





}