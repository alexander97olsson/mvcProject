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
        $numberArray = $diceGame->getAllDices();
        $graphicsArray = $diceGame->getAllDicesGraphic();

        return $this->render('dicetosser.html.twig', [
            "header" => "Toss dice",
            "message" => "This is just for test!",
            "alldices" => $graphicsArray,
        ]);
    }

    public function gameChoice(): Response
    {
        $session = new Session();
        $session->start();
        $session->invalidate();

        return $this->render('dicestart.html.twig', [
            "header" => "Game 21",
            "message" => "This is the game Yatzy!",
        ]);
    }
}