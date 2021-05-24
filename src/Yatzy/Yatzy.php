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
        $session->set('active', 0);

        //taken variables
        $session->set('par', 0);
        $session->set('triss', 0);
        $session->set('fyrtal', 0);
        $session->set('litenstege', 0);
        $session->set('storstege', 0);
        $session->set('kak', 0);
        $session->set('chans', 0);
        $session->set('yatzyPoint', 0);
    }

    public function showGame($sessionValue, $requestValue)
    {
        $session = $sessionValue;
        $request = $requestValue;
        $diceObject = $session->get('yatzyObjekt');

        $numberArray = $diceObject->getAllDices();
        if ($session->get('counter') == 2) {
            if ($request->request->has("chooseRadio")) {
                $chooseRadioValue = $request->request->get("chooseRadio");
                if ($chooseRadioValue == "par" && $session->get('par') == 0) {
                    $this->ofAKind($numberArray, $session, 1);
                    $session->set('par', 1);
                }
                if ($chooseRadioValue == "triss" && $session->get('triss') == 0) {
                    $this->ofAKind($numberArray, $session, 2);
                    $session->set('triss', 1);
                }
                if ($chooseRadioValue == "fyrtal" && $session->get('fyrtal') == 0) {
                    $this->ofAKind($numberArray, $session, 3);
                    $session->set('fyrtal', 1);
                }
                if ($chooseRadioValue == "litenstege" && $session->get('litenstege') == 0) {
                    $this->litenStege($numberArray, $session);
                    $session->set('litenstege', 1);
                }
                if ($chooseRadioValue == "storstege" && $session->get('storstege') == 0) {
                    $this->storStege($numberArray, $session);
                    $session->set('storstege', 1);
                }
                if ($chooseRadioValue == "kak" && $session->get('kak') == 0) {
                    $this->kak($numberArray, $session);
                    $session->set('kak', 1);
                }
                if ($chooseRadioValue == "chans" && $session->get('chans') == 0) {
                    $this->chans($numberArray, $session);
                    $session->set('chans', 1);
                }
                if ($chooseRadioValue == "yatzyPoint" && $session->get('yatzyPoint') == 0) {
                    $this->yatzyPoint($numberArray, $session);
                    $session->set('yatzyPoint', 1);
                }
                $session->set('counter', 0);
                $session->set('active', 0);
            } else {
                $this->calcScore($this->getAllScores($session->get('gameState'), $session), $session);
            }

            $round = $session->get('round');
            $round = $round + 1;
            $session->set('round', $round);
            if ($session->get('round') == 7 && $session->get('score') >= 63) {
                $score = $session->get('score');
                $score = $score + 50;
                $session->set('score', $score);
            }
        }

        if ($session->get('active') == 0) {
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
            if ($session->get('counter') >= 3) {
                $session->set('active', 1);
            }
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
                    $topWithCount = array_keys($counts);
                    $value = $topWithCount[0];
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

    public function litenStege($allDicesValues, $session)
    {
        if ((count(array_unique($allDicesValues)) === 1) == false) {
            if (array_sum($allDicesValues) == 15) {
                $this->calcScore(15, $session);
            }
        }
    }

    public function storStege($allDicesValues, $session)
    {
        if ((count(array_unique($allDicesValues)) === 1) == false) {
            if (array_sum($allDicesValues) == 20) {
                $this->calcScore(20, $session);
            }
        }
    }

    public function kak($allDicesValues, $session)
    {
        if ((count(array_unique($allDicesValues)) === 2)) {
            $sum = array_sum($allDicesValues);
            $this->calcScore($sum, $session);
        }
    }
}
