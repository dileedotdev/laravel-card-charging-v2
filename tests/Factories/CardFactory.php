<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Tests\Factories;

use Dinhdjj\CardChargingV2\Enums\Status;
use Dinhdjj\CardChargingV2\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition()
    {
        $status = Arr::random(Status::cases());

        $declared_value = Arr::random([10, 20, 30, 50, 100, 200, 500, 1000]) * 1000;

        $value = match ($status) {
            Status::SUCCESS => $declared_value,
            Status::FAILED, Status::INCORRECT_CARD => 0,
            Status::INCORRECT_VALUE_SUCCESS => $declared_value + 10000,
            default => null,
        };

        $amount = $declared_value * 70 / 100;

        $serial = $this->faker->regexify('[a-z0-9]{11,15}');
        $code = $this->faker->regexify('[a-z0-9]{11,15}');

        return [
            'status' => $status->value,
            'message' => $status->name,
            'request_id' => $this->faker->uuid(),
            'declared_value' => Arr::random([10, 20, 30, 50, 100, 200, 500, 1000]) * 1000,
            'value' => $value,
            'amount' => $amount,
            'code' => $code,
            'serial' => $serial,
            'telco' => Arr::random(['VIETTEL', 'MOBILE', 'GATE', 'GARENA']),
            'trans_id' => random_int(1, 9999),
            'connection' => config('card-charging-v2.connections.default'),
        ];
    }
}
