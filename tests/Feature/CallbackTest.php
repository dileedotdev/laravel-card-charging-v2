<?php

declare(strict_types=1);

use Dinhdjj\CardChargingV2\Enums\Status;
use Dinhdjj\CardChargingV2\Tests\Factories\CardFactory;
use Dinhdjj\CardChargingV2\Tests\RequestFactories\CallbackRequestFactory;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

beforeEach(function (): void {
    $this->route = route(config('card-charging-v2.callback.name'));
    $this->card = CardFactory::new()->create();
});

it('accept get and post method', function (): void {
    postJson($this->route)->assertStatus(422);
    getJson($this->route)->assertStatus(422);
});

it('require fields', function ($field): void {
    CallbackRequestFactory::new()->without([$field])->fake();

    postJson($this->route)
        ->assertStatus(422)
        ->assertJsonValidationErrorFor($field)
    ;
})->with([
    'trans_id',
    'request_id',
    'amount',
    'value',
    'declared_value',
    'telco',
    'serial',
    'code',
    'status',
    'message',
]);

it('require a valid sign', function (): void {
    CallbackRequestFactory::new($this->card->toArray())
        ->state(['callback_sign' => 'invalid'])
        ->fake()
    ;

    postJson($this->route)
        ->assertStatus(404)
    ;
});

it('should work correctly', function (): void {
    CallbackRequestFactory::new($this->card->getAttributes())
        ->fake()
    ;

    postJson($this->route, [
        'status' => Status::INCORRECT_CARD->value,
        'value' => 987777,
        'amount' => 987767,
        'message' => 'this is message',
    ])
        ->assertOk()
    ;

    $this->card->refresh();

    expect($this->card->status)->toBe(Status::INCORRECT_CARD);
    expect($this->card->value)->toBe(987777);
    expect($this->card->amount)->toBe(987767);
    expect($this->card->message)->toBe('this is message');
});
