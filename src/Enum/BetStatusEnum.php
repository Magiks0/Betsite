<?php

namespace App\Enum;

enum BetStatusEnum: string
{
    case Waiting = 'EN_ATTENTE';
    case Won = 'GAGNE';
    case Lose = 'PERDU';
    case Cancelled  = 'ANNULLE';
}
