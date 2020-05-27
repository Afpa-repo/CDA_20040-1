<?php


namespace App\Controller;


use App\Entity\Products;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 * @method render(string $string, array $array)
 */

class AccueilController extends AbstractController
{

    /**
     *@Route("/",name="accueil")
     */

    public function index(CartService $service)
    {
        $repo = $this->getDoctrine()->getRepository(Products::class);
        $product = $repo->findAll();

        $panier = $service->getCart();


        return $this->render('index.html.twig',['product'=>$product,'panier'=>$panier]);



    }

}