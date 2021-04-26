<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Dice\DiceHand;
use App\Yatzy\Yatzy;

//use function App\Functions\url;

class HelloWorldController extends AbstractController
{
    public function helloMessage(): Response
    {
        return new Response(
            "Hello world, message only"
        );
    }

    public function helloMessageView(): Response
    {
        return $this->render('message.html.twig', [
            'message' => "Hello World in view",
        ]);
    }

    /**
     * @Route("/hello")
    */
    public function hello(): Response
    {
        return $this->render('message.html.twig', [
            'message' => "Hello World as controller annotation",
        ]);
    }

    /**
     * @Route("/hello/{message}")
    */
    public function helloWithArgument(string $message): Response
    {
        return $this->render('message.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/test/{message}")
    */
    public function printMyName(string $message): Response
    {
        return $this->render('printName.html.twig', [
            'message' => $message,
            'name' => "Name: ",
        ]);
    }
}
