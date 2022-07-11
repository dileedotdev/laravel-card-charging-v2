<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Enums;

enum Status :int
{
    case SUCCESS = 1; // Success

    case INCORRECT_VALUE_SUCCESS = 2; // Success but declared value is incorrect

    case INCORRECT_CARD = 3; // Card is incorrect

    case MAINTENANCE = 4; // System maintenance

    case PENDING = 99; // Handling card

    case FAILED = 100; // Send card failed

    case REQUEST_ID_EXISTED = 102; // Request id existed
}
