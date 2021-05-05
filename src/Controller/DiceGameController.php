<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Dice\DiceHand;

//use function App\Functions\url;

class DiceGameController extends AbstractController
{
    public function tossDice(): Response
    {
        $session = new Session();
        $session->start();
        $session->invalidate();

        $diceGame = new DiceHand(3);
        $diceGame->tossAll();
        $diceGame->getAllDices();
        $graphicsArray = $diceGame->getAllDicesGraphic();

        return $this->render('dicetosser.html.twig', [
            "header" => "Toss dice",
            "message" => "This is just for test!",
            "alldices" => $graphicsArray,
        ]);
    }
}
