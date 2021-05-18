<?php

declare(strict_types=1);

namespace App\Yatzy;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Dice\DiceHand;

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
            if ($session->get('round') == 1) {
                $this->kak($numberArray, $session);
                $session->set('counter', 0);
            }
            if ($session->get('round') == 2) {
                $this->kak($numberArray, $session);
                $session->set('counter', 0);
            }
            if ($session->get('round') == 3) {
                $this->kak($numberArray, $session);
                $session->set('counter', 0);
            }
            if ($session->get('round') == 4) {
                $this->storStege($numberArray, $session);
                $session->set('counter', 0);
            }
            $round = $session->get('round');
            $round = $round + 1;
            $session->set('round', $round);
            if ($session->get('round') == 7 && $session->get('score') >= 63) {
                $score = $session->get('score');
                $score = $score + 50;
                $session->set('score', $score);
            }
            //$this->calcScore($this->getAllScores($session->get('gameState'), $session), $session);
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

    public function chans($allDicesValues, $session)
    {
        $sum = array_sum($allDicesValues);
        $this->calcScore($sum, $session);
    }

    public function yatzyPoint($allDicesValues, $session)
    {
        if ((count(array_unique($allDicesValues)) === 1)) {
            $this->calcScore(50, $session);
        }
    }

    public function ofAKind($allDicesValues, $session, $ofAKindNumber)
    {
        $sum = 0;
        $isThreeOfAKind = false;
        $countArray = count($allDicesValues);
        $value = 0;

        for ($i = 1; $i <= $countArray + 1; $i++) { 
            $count = 0;
            for ($j = 0; $j < $countArray; $j++) { 
                if ($allDicesValues[$j] == $i) {
                    $count = $count + 1;
                }
                
                if ($count > $ofAKindNumber) {
                    $isThreeOfAKind = true;
                    $counts = array_count_values($allDicesValues);
                    arsort($counts);
                    $top_with_count = array_keys($counts);
                    $value = $top_with_count[0];
                }
            }
        }

        $timesOfCalc = 0;
        if ($isThreeOfAKind == true) {
            for ($i = 0; $i < $countArray; $i++) { 
                if ($value == $allDicesValues[$i] && $timesOfCalc < $ofAKindNumber + 1) {
                    $sum = $sum + $allDicesValues[$i];
                    $timesOfCalc = $timesOfCalc + 1;
                }
            }
        }

        $this->calcScore($sum, $session);
    }

    public function litenStege($allDicesValues, $session) {
        if ((count(array_unique($allDicesValues)) === 1) == false) {
            if (array_sum($allDicesValues) == 15) {
                $this->calcScore(15, $session);
            }
        }
    }

    public function storStege($allDicesValues, $session) {
        if ((count(array_unique($allDicesValues)) === 1) == false) {
            if (array_sum($allDicesValues) == 20) {
                $this->calcScore(20, $session);
            }
        }
    }

    public function kak($allDicesValues, $session) {
        if ((count(array_unique($allDicesValues)) === 2)) {
            $sum = array_sum($allDicesValues);
            $this->calcScore($sum, $session);
        }
    }
}
