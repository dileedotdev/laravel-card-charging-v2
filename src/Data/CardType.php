<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Data;

class CardType
{
    public function __construct(
        public string $telco,
        public int $value,
        public int $fees,
        public int $penalty,
    ) {
    }
}
