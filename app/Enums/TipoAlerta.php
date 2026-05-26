<?php

namespace App\Enums;

enum TipoAlerta:int
{
    case SUCCESS = 1;
    case DANGER = 2;
    case WARNING = 3;
    case INFO = 4;
}
