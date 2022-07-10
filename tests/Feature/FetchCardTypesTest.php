<?php

declare(strict_types=1);

use Dinhdjj\CardChargingV2\Facades\CardChargingV2;
use Dinhdjj\CardChargingV2\Tests\CardChargingV2ServerFaker;
use Illuminate\Http\Client\RequestException;

it('should fetch card types', function (): void {
    $faker = CardChargingV2ServerFaker::make()->fakeGetFee();

    $rawCardTypes = $faker->cardTypes;

    $cardTypes = CardChargingV2::getFee();

    expect($cardTypes)->toHaveCount(count($rawCardTypes));
    expect($cardTypes[0]->telco)->toEqual($rawCardTypes[0]['telco']);
    expect($cardTypes[0]->value)->toEqual($rawCardTypes[0]['value']);
    expect($cardTypes[0]->fees)->toEqual($rawCardTypes[0]['fees']);
    expect($cardTypes[0]->penalty)->toEqual($rawCardTypes[0]['penalty']);

    $lastIndex = count($rawCardTypes) - 1;

    expect($cardTypes[$lastIndex]->telco)->toEqual($rawCardTypes[$lastIndex]['telco']);
    expect($cardTypes[$lastIndex]->value)->toEqual($rawCardTypes[$lastIndex]['value']);
    expect($cardTypes[$lastIndex]->fees)->toEqual($rawCardTypes[$lastIndex]['fees']);
    expect($cardTypes[$lastIndex]->penalty)->toEqual($rawCardTypes[$lastIndex]['penalty']);
});

it('should throw if has any errors', function (): void {
    $faker = CardChargingV2ServerFaker::make()->fakeGetFee(success: false);

    CardChargingV2::getFee();
})->throws(RequestException::class);
