<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     */
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**public function createBook(Request $request): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action:
        //  createProduct(EntityManagerInterface $entityManager)

        $entityManager = $this->getDoctrine()->getManager();

        $book = new Book();
        $book->setTitle("Borta med vinden");
        $book->setAuthor("Margareth Mitchell");
        $book->setISBN("96783-8566");
        $book->setPicture("https://www.listor.se/wp-content/uploads/2014/01/bortamedvinden.jpg");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$book->getId());
    }*/

    /**
     * @Route("/allbooks", name="find_all_books")
     */
    public function findAllBooks(
        EntityManagerInterface $entityManager
    ): Response {
        $books = $entityManager
            ->getRepository(Book::class)
            ->findAll();

        return $this->render('book/showBooks.html.twig', [
            "books" => $books,
        ]);
    }
}
