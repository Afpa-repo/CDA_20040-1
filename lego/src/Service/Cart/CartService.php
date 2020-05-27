<?php


namespace App\Service\Cart;


use App\Entity\Cart;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductsRepository;

class CartService
{
    protected $session;
    protected $productrepo;
    protected $manager;


    public function __construct(SessionInterface $session, ProductsRepository $productrepo, EntityManagerInterface $manager)
    {
        $this->session = $session;
        $this->productrepo = $productrepo;
        $this->manager = $manager;

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

        if(!empty($panier))
        {
            $order = new Order();
            $order->setDeliveryAdress('ex')
                    ->setDeliveryDate(new \DateTime)
                    ->setOrderDate(new \DateTime)
                    ->setShippingPrice(25)
                    ->setStatus("Valider");
            $this->manager->persist($order);


            //dd($this->getCart());
            foreach($this->getCart() as $item)
            {
                $cart = new Cart();
                $cart->addProduct($item['product'])
                    ->setQuantity($item['quantity'])
                    ->setTotalCost($item['product']->getPrice() * $item['quantity'])
                    ->setOrdercart($order);
             $this->manager->persist($cart);


             $this->deleteProduct($item['product']->getid());
            }

            $this->manager->flush();


        }



    }

}