<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class CardChargingV2ServerFaker
{
    public function __construct(
        public array $cardTypes = [],
    ) {
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
            if (!$this->cardTypes) {
                $this->factoryCardTypes();
            }

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
}
