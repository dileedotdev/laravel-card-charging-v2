<?php

declare(strict_types=1);

use Dinhdjj\CardChargingV2\Enums\Status;
use Dinhdjj\CardChargingV2\Facades\CardChargingV2;
use Dinhdjj\CardChargingV2\Tests\CardChargingV2ServerFaker;

it('should work', function (Status $status): void {
    CardChargingV2ServerFaker::make()->fakeCharging(status: $status);

    $card = CardChargingV2::charging('VIETTEL', 10000, '100037483843245', '100037483843245', '33');

    expect($card->status)->toBe($status);
})->with(Status::cases());

it('should work with SUCCESS status', function (): void {
    CardChargingV2ServerFaker::make()->fakeCharging(status: Status::SUCCESS, fees: 28);

    $card = CardChargingV2::charging('VIETTEL', 10000, '100037483843245', '100037483843245', '33');

    expect($card->amount)->toBe(7200);
    expect($card->value)->toBe(10000);
});

it('should work with INCORRECT_VALUE_SUCCESS status', function (): void {
    CardChargingV2ServerFaker::make()->fakeCharging(status: Status::INCORRECT_VALUE_SUCCESS, fees: 28, penalty: 50);

    $card = CardChargingV2::charging('VIETTEL', 10000, '100037483843245', '100037483843245', '33');

    expect($card->amount)->toBe(2200);
    expect($card->value)->not()->toBe(10000);
});

it('should work with PENDING status', function (): void {
    CardChargingV2ServerFaker::make()->fakeCharging(status: Status::PENDING, fees: 28);

    $card = CardChargingV2::charging('VIETTEL', 10000, '100037483843245', '100037483843245', '33');

    expect($card->amount)->toBe(7200);
    expect($card->value)->toBe(null);
});

it('should work with INCORRECT_CARD status', function (): void {
    CardChargingV2ServerFaker::make()->fakeCharging(status: Status::INCORRECT_CARD, fees: 28);

    $card = CardChargingV2::charging('VIETTEL', 10000, '100037483843245', '100037483843245', '33');

    expect($card->amount)->toBe(0);
    expect($card->value)->toBe(0);
});
