<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    // 1. تسجيل الدخول
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string', // يطابق اسم المستخدم أو الهاتف
            'password' => 'required|string',
        ]);

        $identifier = $request->input('identifier');
        $password = $request->input('password');

        // نتحقق إن كان الـ identifier هو إيميل/اسم مستخدم أو رقم هاتف
        $fieldType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($identifier) ? 'phone' : 'username');

        $credentials = [
            $fieldType => $identifier,
            'password' => $password,
        ];

        // المحاولة باستخدام Guard الـ API و JWT
        /** @var \Tymon\JWTAuth\JWTGuard $auth */
        $auth = auth('api');

        if (! $token = $auth->attempt($credentials)) {
            return response()->json(['message' => 'اسم المستخدم أو كلمة السر غلط'], 401);
        }

        $user = $auth->user();

        return response()->json([
            'data' => [
                'id' => (string) $user->id,
                'fullname' => $user->fullname ?? null,
                'username' => $user->username ,
                'phone' => $user->phone,
                'role' => $user->role,
                'staff_id' => $user->staff ? (string) $user->staff->id : null,
                 'player_id' => $user->player
            ? (string) $user->player->id
            : null,
                ],
            'token' => $token,
        ], 200);
    }

    // 2. جلب بيانات المستخدم الحالية (عند فتح التطبيق)
    public function me()
    {
        $user = auth('api')->user();

        return response()->json([
            'data' => [
                'id' => (string) $user->id,
                'fullname' => $user->fullname,
                'username' => $user->username ?? $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'staff_id' => $user->staff ? (string) $user->staff->id : null,
                'player_id' => $user->player
            ? (string) $user->player->id
            : null,
                ]
        ], 200);
    }

    // 3. تسجيل الخروج
    public function logout()
    {
        /** @var \Tymon\JWTAuth\JWTGuard $auth */
        $auth = auth('api');

        $auth->logout();

        return response()->json(['message' => 'تم تسجيل الخروج بنجاح'], 200);
    }

    // 4. تجديد التوكين (Refresh Token)
    public function refresh()
    {
        /** @var \Tymon\JWTAuth\JWTGuard $auth */
        $auth = auth('api');

        return response()->json([
            'token' => $auth->refresh()
        ], 200);
    }
}
