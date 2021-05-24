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
    /**
     * @Route("/hello")
    */
    public function hello(): Response
    {
        return $this->render('message.html.twig', [
            'message' => "Hejsan detta är min start sida, välkommen",
        ]);
    }
}
