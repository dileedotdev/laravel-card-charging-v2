<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2\Controllers;

use Dinhdjj\CardChargingV2\Enums\Status;
use Dinhdjj\CardChargingV2\Events\CallbackCalled;
use Dinhdjj\CardChargingV2\Facades\CardChargingV2;
use Dinhdjj\CardChargingV2\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'status' => ['required', 'integer'],
            'message' => ['required', 'string'],
            'request_id' => ['required', 'string'],
            'declared_value' => ['required', 'integer'],
            'value' => ['present', 'nullable', 'integer'],
            'amount' => ['present', 'nullable', 'integer'],
            'code' => ['required', 'string'],
            'serial' => ['required', 'string'],
            'telco' => ['required', 'string'],
            'trans_id' => ['required', 'integer'],
            'callback_sign' => ['required', 'string'],
        ]);

        $card = $this->findCardOrFail($request);

        $card->forceFill([
            'status' => Status::from($request->status),
            'message' => $request->message,
            'value' => $request->value,
            'amount' => $request->amount,
        ])->save();

        config('card-charging-v2.callback.event', CallbackCalled::class)::dispatch($card);

        return response()->json([
            'message' => 'Request accepted!',
        ], 200);
    }

    public function findCardOrFail(Request $request): Card
    {
        $model = CardChargingV2::getCardModel();

        $cards = $model::whereTelco($request->telco)
            ->whereSerial($request->serial)
            ->whereCode($request->code)
            ->whereTransId($request->trans_id)
            ->whereRequestId($request->request_id)
            ->whereDeclaredValue($request->declared_value)
            ->get()
        ;

        foreach ($cards as $card) {
            /** @var Card $card */
            if ($card->sign === $request->callback_sign) {
                return $card;
            }
        }

        abort(404, 'Card not found');
    }
}
