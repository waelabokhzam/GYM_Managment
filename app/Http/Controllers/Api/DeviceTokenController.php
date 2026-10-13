<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    /**
     * حفظ token الجهاز (أو نقله للمستخدم الحالي لو كان مسجل لمستخدم تاني).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string', 'max:512'],
            'platform' => ['nullable', 'in:android,ios'],
        ]);

        // updateOrCreate على الـ token بالذات: لو مستخدم تاني سجل دخول على نفس الجهاز،
        // الـ token بينتقل إله، فما بتوصل إشعارات المستخدم السابق لهاد الجهاز
        DeviceToken::updateOrCreate(
            ['token' => $validated['token']],
            [
                'user_id' => $request->user()->id,
                'platform' => $validated['platform'] ?? 'android',
            ]
        );

        return response()->json(['success' => true]);
    }

    /**
     * حذف token الجهاز (عند تسجيل الخروج).
     */
    public function destroy(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $request->user()
            ->deviceTokens()
            ->where('token', $validated['token'])
            ->delete();

        return response()->json(['success' => true]);
    }
}
