<?php


namespace App\Controller;
use App\Entity\Products;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

    /**
     * @Route("/handleSearch/{_query?}", name="handle_search", methods={"POST","GET"})
    */

    public function handleSearchRequest(string $_query)
    {
        $em = $this->getDoctrine()->getManager();

        if($_query)
        {
            $data = $em->getRepository(Products::class)->findByName($_query);

        }
        else
        {
            $data = $em->getRepository(Products::class)->findAll();
        }

        $normalizers =[new ObjectNormalizer()];

        $encorders = [
            new JsonEncoder()
        ];

        $serializer = new Serializer($normalizers, $encorders);

        $data = $serializer->serialize($data,'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['supplier'],['cart']]);



        return new JsonResponse($data, 200 ,[], true);
    }

}