<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Events;

use Dinhdjj\CardChargingV2\Models\Card;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallbackCalled
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Card $card;

    public function __construct(
        public Card $order
    ) {
    }
}
