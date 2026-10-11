<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PrivatePlayersController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $staff = $request->user()->staff;

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'حساب المدرب غير موجود.',
            ], 404);
        }

        // اللاعبين يلي عندهم اشتراك "خاص" فعّال مع هاد المدرب تحديداً
        $subscriptions = Subscription::query()
            ->where('trainer_id', $staff->id)
            ->where('sub_type', 'special')
            ->where('status', 'active')
            ->with('player.user')
            ->get();

        $data = $subscriptions->map(function (Subscription $subscription) {
            $player = $subscription->player;

            return [
                'id' => $player->id,
                'full_name' => $player->user->fullname,
                'avatar_url' => null, // لسا ما عندنا نظام صور
                'has_active_training_program' => $player->trainingPrograms()->exists(),
                'has_active_nutrition_program' => $player->nutritionPrograms()->exists(),
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
