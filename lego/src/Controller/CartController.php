<?php

namespace App\Controller;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $service)
    {
        return $this->render('cart/index.html.twig', ['items' => $service->getCart(), 'total' => $service->getTotal() , 'number' => $service->numberItems()]);
    }

    /**
     * @Route("/panier/add/{id}",name="cart_add")
     */
    public function addcart($id, CartService $service)
    {
        $service->add($id);
        return $this->redirectToroute('cart_index');
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $service)
    {
        $service->remove($id);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("panier/delete/{id}", name="cart_delete")
    */
    public function delete($id, CartService $service)
    {
        $service->deleteProduct($id);
        return $this->redirectToRoute('cart_index');

    }

    /**
     * @Route("panier/valider", name="cart_validation")
     */

    public function valider(CartService $service)
    {

        $service->valider();
        return $this->redirectToroute('cart_index');

    }
}
