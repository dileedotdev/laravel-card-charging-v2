<?php

namespace Dinhdjj\CardChargingV2\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dinhdjj\CardChargingV2\CardChargingV2
 */
class CardChargingV2 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'card-charging-v2';
    }
}
