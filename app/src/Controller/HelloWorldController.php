<?php

namespace App\Controller;

use alos17\Dice\DiceHand;
use alos17\Yatzy\Yatzy;

use function Mos\Functions\{
    destroySession,
    renderView,
    url
};

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/test")
    */
    public function testarFunc(): Response
    {
        return new Response(
            "this is my first controller"
        );
    }

    public function showStartGame(): Response
    {
        //destroySession();

        $data = [
            "header" => "Yatzy game",
            "action" => url("/yatzyGame/showGame"),
            "message" => "This is the game Yatzy!",
        ];

        return $this->render('yatzystart.php', $data);
    }

    public function showGame(): Response
    {
        if (!isset($_SESSION["yatzyGame"])) {
            $_SESSION["yatzyGame"] = serialize(new Yatzy());
        }
        $game = unserialize($_SESSION["yatzyGame"]);
        $game->showGame();
        $psr17Factory = new Psr17Factory();
        $data = [
            "header" => "Yatzy game",
            "message" => "This is the game Yatzy!",
        ];

        $data["totalSum"] = $_SESSION["totalSum"];
        $data["firstToss"] = $_SESSION["firstToss"];
        $data["alldices"] = $_SESSION["alldices"];
        $data["text"] = $_SESSION["text"];

        $body = renderView("layout/yatzy.php", $data);
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }
}
