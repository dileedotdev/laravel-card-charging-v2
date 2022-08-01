<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Dinhdjj\CardChargingV2\CardChargingV2 connection(null|array|string $connection = null)                                        Use specific connection.
 * @method static \Dinhdjj\CardChargingV2\Data\CardType[] getFee()                                                                               Fetch card types from thesieure.
 * @method static \Dinhdjj\CardChargingV2\Data\Card charging(string $telco, int $declaredValue, string $serial, string $code, string $requestId) Send card to server for charging/approving.
 * @method static \Dinhdjj\CardChargingV2\Data\Card check(string $telco, int $declaredValue, string $serial, string $code, string $requestId)    Send card to server to check/update latest status card.
 * @method static string getCardModel()                                                                                                          Get card model class name.
 * @method static string generateSign(string $serial, string $code)                                                                              Generate sign for charging/checking request.
 *
 * @see \Dinhdjj\CardChargingV2\CardChargingV2
 */
class CardChargingV2 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'card-charging-v2';
    }
}
