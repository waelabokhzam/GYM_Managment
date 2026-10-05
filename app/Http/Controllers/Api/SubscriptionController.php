<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function getPlayerSubscriptions(Request $request)
    {
        $player = $request->user()->player;

        if (!$player) {
            return response()->json([
                'status' => false,
                'message' => 'الملف الشخصي للاعب غير موجود'
            ], 404);
        }

        // جلب كل الاشتراكات مع ترتيب النشط أولاً ثم حسب التاريخ الأحدث
        $subscriptions = Subscription::where('player_id', $player->id)
            ->orderByRaw("status = 'active' DESC")
            ->orderBy('start_date', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'تم جلب سجل الاشتراكات بنجاح',
            'subscriptions' => $subscriptions->map(function ($sub) {
                return [
                    'id' => $sub->id,
                    'sub_type' => $sub->sub_type,
                    'registration_type' => $sub->registration_type,
                    'start_date' => $sub->start_date ? $sub->start_date->format('Y-m-d') : '',
                    'end_date' => $sub->end_date ? $sub->end_date->format('Y-m-d') : '',
                    'status' => $sub->status,
                    'amount' => $sub->amount,
                ];
            })
        ]);
    }
}
