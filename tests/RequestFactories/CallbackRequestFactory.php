<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Tests\RequestFactories;

use Dinhdjj\CardChargingV2\Facades\CardChargingV2;
use Dinhdjj\CardChargingV2\Tests\Factories\CardFactory;
use Worksome\RequestFactories\RequestFactory;

class CallbackRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $card = CardFactory::new()->raw();
        $callbackSign = CardChargingV2::generateSign($card['serial'], $card['code']);

        $connection = $card['connection'];
        unset($card['connection']);

        return [
            ...$card,
            'callback_sign' => fn ($attributes) => CardChargingV2::connection($connection)
                ->generateSign(
                    $attributes['serial'],
                    $attributes['code']
                ),
        ];
    }
}
