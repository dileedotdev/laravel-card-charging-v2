<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Data;

use Dinhdjj\CardChargingV2\Enums\Status;

class Card
{
    public function __construct(
        public ?int $trans_id, /** Id created by thesieure */
        public string $request_id,
        public ?int $amount, /** Actual money received */
        public ?int $value, /** Real value */
        public int $declared_value,
        public string $telco,
        public string $serial,
        public string $code,
        public Status $status,
        public string $message,
    ) {
    }
}
