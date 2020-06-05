<?php


namespace App\Controller;
use App\Entity\Products;
use App\Service\Cart\CartService;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

        return $this->render('index.html.twig',['product'=>$repo->findAll(),'panier'=>$service->getCart(),'number'=> $service->numberItems()]);
    }

    /**
     *@Route("/gamme/{gamme}",name="gamme")
     */
    public function parGamme(CartService $service, string $gamme)
    {
        $repo = $this->getDoctrine()->getRepository(Products::class);

        return $this->render('index.html.twig',['product'=>$repo->findBy(['Gamme'=>$gamme]),'panier'=>$service->getCart(),'number'=> $service->numberItems()]);
    }

    /**
     *@Route("/theme/{theme}",name="theme")
     */
    public function parTheme(CartService $service, string $theme)
    {
        $repo = $this->getDoctrine()->getRepository(Products::class);


        return $this->render('index.html.twig',['product'=>$repo->findBy(['Theme'=>$theme]),'panier'=>$service->getCart(),'number'=> $service->numberItems()]);
    }

    /**
     *@Route("/price/{price}",name="price")
     */
    public function parPrice(CartService $service, int $price)
    {
        $repo = $this->getDoctrine()->getRepository(Products::class);

        $products = $repo->findAll();

        if($price === 1)
        {
            foreach($products as $product )
            {

                if($product->getPrice() <= 50)
                {

                    $productri[] = $product;

                }

            }

        }
        elseif ($price === 51)
        {
            foreach($products as $product )
            {

                if($product->getPrice() > 50 && $product->getPrice() <=100 )
                {

                    $productri[] = $product;

                }

            }

        }
        else
        {
            foreach($products as $product )
            {

                if($product->getPrice() > 100 )
                {

                    $productri[] = $product;

                }

            }
        }

        return $this->render('index.html.twig',['product'=>$productri,'panier'=>$service->getCart(),'number'=> $service->numberItems()]);

    }

 /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail(Products $detail)
    {
        return $this->render('detail.html.twig', [
            'detail' => $detail
        ]);
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

        $data = $serializer->serialize($data,'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['supplier']]);



        return new JsonResponse($data, 200 ,[], true);
    }

    /**
     * @Route("add/{id}",name="acc_add")
     */
    public function addhome($id, CartService $service)
    {
        $service->add($id);
        return $this->redirectToroute('accueil');
    }

}