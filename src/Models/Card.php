<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Models;

use Dinhdjj\CardChargingV2\Enums\Status;
use Dinhdjj\CardChargingV2\Facades\CardChargingV2;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int                                  $id
 * @property int                                  $trans_id
 * @property string                               $request_id
 * @property ?int                                 $amount
 * @property ?int                                 $value
 * @property int                                  $declared_value
 * @property string                               $telco
 * @property string                               $serial
 * @property string                               $code
 * @property \Dinhdjj\CardChargingV2\Enums\Status $status
 * @property string                               $message
 * @property array                                $connection
 * @property ?\Illuminate\Support\Carbon          $created_at
 * @property ?\Illuminate\Support\Carbon          $deleted_at
 */
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
