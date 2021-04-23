<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use alos17\Dice\DiceHand;
use alos17\Yatzy\Yatzy;

use function Mos\Functions\{
    destroySession,
    renderView,
    url
};

class YatzyGameController extends AbstractController
{
    public function showStartGame(): Response
    {
        $session = new Session();
        $session->start();
        $session->invalidate();

        $session->set('counter', 0);
        $session->set('score', 0);
        $session->set('round', 1);

        return $this->render('yatzystart.html.twig', [
            "header" => "Yatzy game",
            "action" => url("/yatzy"),
            "message" => "This is the game Yatzy!",
        ]);
    }

    public function showGame(Request $request): Response
    {
        $session = $this->get('session');
        if ($session->has('yatzyGame') == false) {
            $session->set("yatzyGame", new Yatzy($session));
        }

        $game = $session->get('yatzyGame');
        $game->showGame($session, $request);

        return $this->render('yatzy.html.twig', [
            "header" => "Yatzy game",
            "action" => url("/yatzy"),
            "message" => "This is the game Yatzy!",
            "totalSum" => $session->get('totalSum'),
            "firstToss" => $session->get('firstToss'),
            "alldices" => $session->get('alldices'),
            "text" => $session->get('text'),
            "round" => $session->get('round'),
            "counter" => $session->get('counter'),
            "score" => $session->get('score'),
        ]);
    }
}
