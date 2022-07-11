<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Models;

use Dinhdjj\CardChargingV2\Enums\Status;
use Dinhdjj\CardChargingV2\Facades\CardChargingV2;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $hidden = [
        'trans_id',
        'request_id',
        'code',
        'connection',
    ];

    protected $casts = [
        'status' => Status::class,
        'connection' => 'array',
    ];

    protected $appends = [
    ];

    public function getTable(): string
    {
        return config('card-charging-v2.card.table', 'card_charging_v2');
    }

    public function getSignAttribute(): string
    {
        return CardChargingV2::connection($this->getAttribute('connection'))
            ->generateSign($this->serial, $this->code)
        ;
    }
}
