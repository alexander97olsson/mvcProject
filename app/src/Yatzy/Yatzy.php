<?php

declare(strict_types=1);

namespace alos17\Yatzy;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use alos17\Dice\DiceHand;

class Yatzy
{
    public function __construct($sessionValue)
    {
        $session = $sessionValue;
        
        $session->set('yatzyObjekt', new DiceHand(5));
        $session->set('counter', 0);
        $session->set('gameState', 1);
        $session->set('score', 0);
        $session->set('round', 1);
    }
    
    public function showGame($sessionValue, $requestValue)
    {
        $session = $sessionValue;
        $request = $requestValue;
  
        $diceObject = $session->get('yatzyObjekt');
        if ($request->request->has("Toss")) {
            if ($request->request->has("dicesArray")) {
                $dicesArray = $request->request->get("dicesArray");
                $diceObject->setAllDices($session->get('numberOfValues'));
                $countArray = count($dicesArray);
                for ($i = 0; $i < $countArray; $i++) {
                    $diceObject->tossSpecific(intval($dicesArray[$i]));
                }
            } else {
                $diceObject->setAllDices($session->get('numberOfValues'));
            }
            $counter = $session->get('counter');
            $counter = $counter + 1;
            $session->set('counter', $counter);
        } else {
            $diceObject->tossAll();
        }

        $numberArray = $diceObject->getAllDices();
        $graphicsArray = $diceObject->getAllDicesGraphic();
        $totalSum = $diceObject->getSumHand();

        $session->set('totalSum', $totalSum);
        $session->set('firstToss', $diceObject->getSumHand());
        $session->set('alldices', $graphicsArray);
        $session->set('text', $numberArray);
        $session->set('numberOfValues', $numberArray);

        if ($session->get('counter') == 3) {
            $round = $session->get('round');
            $round = $round + 1;
            $session->set('round', $round);
            if ($session->get('round') == 7 && $session->get('score') >= 63) {
                $score = $session->get('score');
                $score = $score + 50;
                $session->set('score', $score);
            }
            $this->calcScore($this->getAllScores($session->get('gameState'), $session), $session);
        }
    }

    public function getAllScores(int $number, $sessionValue)
    {
        $session = $sessionValue;

        $amount = 0;
        $numberArray = $session->get('numberOfValues');
        $countArray = count($numberArray);
        for ($i = 0; $i < $countArray; $i++) {
            if ($numberArray[$i] == $number) {
                $amount = $amount + 1;
            }
        }
        $session->set('counter', 0);
        $gameState = $session->get('gameState');
        $gameState = $gameState + 1;
        $session->set('gameState', $gameState);
        return $amount * $number;
    }

    public function calcScore(int $number, $sessionValue)
    {
        $session = $sessionValue;

        $score = $session->get('score');
        $score = $score + $number;
        $session->set('score', $score);
    }
}
