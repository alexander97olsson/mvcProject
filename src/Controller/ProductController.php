<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
    /**
     * @Route("/product/create", name="create_product", methods={"POST"})
     */
    public function createProduct(Request $request): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action:
        //  createProduct(EntityManagerInterface $entityManager)
        $name = "temp";
        if ($request->request->has("nameValue")) {
            $name = $request->request->get("name");
        }

        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName($name . rand(1, 9));
        $product->setValue(rand(100, 999));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id ' . $product->getId());
    }
    /**
     * @Route("/product/all", name="find_all_product")
     */
    public function findAllProduct(
        EntityManagerInterface $entityManager
    ): Response {
        $products = $entityManager
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('product/printAllproducts.html.twig', [
            "products" => $products,
        ]);
    }
}
