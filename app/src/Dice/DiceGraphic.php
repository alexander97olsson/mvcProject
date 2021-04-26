<?php

declare(strict_types=1);

namespace App\Dice;

class DiceGraphic extends Dice
{
    public function __construct()
    {
        parent::__construct(6);
    }

    public function graphics()
    {
        return "dice-" . $this->lastToss;
    }
}
