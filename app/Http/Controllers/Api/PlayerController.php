<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\JsonResponse;

class PlayerController extends Controller
{
    /**
     * جلب بيانات اللاعب المسجل دخوله.
     */
    public function me(): JsonResponse
    {
        $user = auth('api')->user();

        // التأكد من وجود مستخدم مصادق عليه
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'غير مصرح لك بالوصول.',
            ], 401);
        }

        // جلب اللاعب المرتبط بالمستخدم الحالي
        $player = Player::with('user')
            ->where('user_id', $user->id)
            ->first();

        // المستخدم موجود ولكن لا يوجد له سجل لاعب
        if (!$player) {
            return response()->json([
                'status' => false,
                'message' => 'لا توجد بيانات لاعب مرتبطة بهذا الحساب.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'تم جلب بيانات اللاعب بنجاح.',
            'player' => $player,
        ], 200);
    }
}