<?php


namespace App\Service\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductsRepository;


class CartService
{
    protected $session;
    protected $productrepo;
    protected $manager;



    public function __construct(SessionInterface $session, ProductsRepository $productrepo, EntityManagerInterface $manager, UserRepository $user)
    {
        $this->session = $session;
        $this->productrepo = $productrepo;
        $this->manager = $manager;
        $this->user = $user;

    }

    public function add(int $id){

        $panier = $this->session->get('panier', []);

        if (isset($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }


        $this->session->set('panier', $panier);
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

    public function valider ()
    {
        $panier = $this->session->get('panier', []);
        $mail = $this->session->get('_security.last_username');
        $id = $this->user->findOneBy(['email'=>$mail])->getId();
        $user = $this->user->find($id);

        if (!empty($panier)) {
            $order = new Order();
            $order->setDeliveryAdress('ex')
                ->setDeliveryDate(new \DateTime)
                ->setOrderDate(new \DateTime)
                ->setShippingPrice(25)
                ->setStatus("Valider");
            $this->manager->persist($order);



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