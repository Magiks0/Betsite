<?php

namespace App\Enum;

enum EventStatusEnum: string
{
    case Draft = 'BROUILLON';
    case Published = 'PUBLIE';
    case Closed = 'FERME';
    case Ended  = 'TERMINE';
    case Cancelled  = 'ANNULLE';
}
