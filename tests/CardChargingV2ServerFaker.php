<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Tests;

use Dinhdjj\CardChargingV2\Enums\Status;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class CardChargingV2ServerFaker
{
    public function __construct(
        public array $cardTypes = [],
        public int $transId = 0,
    ) {
        if (!$this->cardTypes) {
            $this->factoryCardTypes();
        }
    }

    public static function make(
        array $cardTypes = [],
    ): static {
        return new static($cardTypes);
    }

    /**
     * Flush card types.
     *
     * @return $this
     */
    public function flushCardTypes(): static
    {
        $this->cardTypes = [];

        return $this;
    }

    /**
     * Add given card type to set of card types.
     *
     * @return $this
     */
    public function addCardType(array $cardType): static
    {
        $this->cardTypes[] = -$cardType;

        return $this;
    }

    /**
     * Factory a set of fake card types.
     *
     * @return $this
     */
    public function factoryCardTypes(): static
    {
        $this->cardTypes = [
            [
                'telco' => 'VIETTEL',
                'value' => 10000,
                'fees' => 30,
                'penalty' => 20,
            ],
            [
                'telco' => 'VIETTEL',
                'value' => 20000,
                'fees' => 30,
                'penalty' => 20,
            ],
            [
                'telco' => 'VIETTEL',
                'value' => 50000,
                'fees' => 30,
                'penalty' => 20,
            ],
            [
                'telco' => 'VIETTEL',
                'value' => 100000,
                'fees' => 30,
                'penalty' => 20,
            ],
            [
                'telco' => 'VINAPHONE',
                'value' => 10000,
                'fees' => 28,
                'penalty' => 30,
            ],
            [
                'telco' => 'VINAPHONE',
                'value' => 20000,
                'fees' => 28,
                'penalty' => 30,
            ],
            [
                'telco' => 'VINAPHONE',
                'value' => 50000,
                'fees' => 28,
                'penalty' => 30,
            ],
            [
                'telco' => 'VINAPHONE',
                'value' => 100000,
                'fees' => 28,
                'penalty' => 30,
            ],
        ];

        return $this;
    }

    /**
     * Fake http request to fetch card types.
     *
     * @return $this
     */
    public function fakeGetFee(bool $success = true): static
    {
        if ($success) {
            Http::fake([
                'thesieure.com/chargingws/v2/getfee*' => fn (Request $request) => Http::response($this->cardTypes),
            ]);
        } else {
            Http::fake([
                'thesieure.com/chargingws/v2/getfee*' => fn (Request $request) => Http::response($this->cardTypes, 500),
            ]);
        }

        return $this;
    }

    public function fakeCharging(Status $status = Status::SUCCESS, int $fees = 30, int $penalty = 40, ?string $message = null): static
    {
        Http::fake([
            'thesieure.com/chargingws/v2' => function (Request $request) use ($status, $fees, $penalty, $message) {
                if (\in_array($status, [Status::MAINTENANCE, Status::REQUEST_ID_EXISTED, Status::FAILED], true)) {
                    return Http::response([
                        'message' => $status->name,
                        'status' => $message ?? $status->value,
                    ], 200);
                }

                $resData = $request->data();

                $data = [
                    'trans_id' => ++$this->transId,
                    'request_id' => $resData['request_id'],
                    'declared_value' => $resData['amount'],
                    'telco' => $resData['telco'],
                    'serial' => $resData['serial'],
                    'code' => $resData['code'],
                    'status' => $status->value,
                    'message' => $message ?? $status->name,
                ];

                if (Status::PENDING === $status) {
                    $data['amount'] = $resData['amount'] * (100 - $fees) / 100;
                    $data['value'] = null;
                }

                if (Status::SUCCESS === $status) {
                    $data['amount'] = $resData['amount'] * (100 - $fees) / 100;
                    $data['value'] = $data['declared_value'];
                }

                if (Status::INCORRECT_VALUE_SUCCESS === $status) {
                    $data['amount'] = $resData['amount'] * (100 - $fees - $penalty) / 100;
                    $data['value'] = $data['declared_value'] + 10000;
                }

                if (Status::INCORRECT_CARD === $status) {
                    $data['amount'] = 0;
                    $data['value'] = 0;
                }

                return Http::response($data);
            },
        ]);

        return $this;
    }

    public function fakeCheck(Status $status = Status::SUCCESS, int $fees = 30, int $penalty = 40): static
    {
        return $this->fakeCharging(...\func_get_args());
    }
}
