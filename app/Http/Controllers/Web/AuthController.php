<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * توليد Username فريد
     */
    private function generateUniqueUsername(): string
    {
        do {
            $username = 'gym_' . strtoupper(
                substr(
                    str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'),
                    0,
                    6
                )
            );
        } while (User::where('username', $username)->exists());

        return $username;
    }

    /**
     * عرض صفحة التسجيل
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * إنشاء حساب جديد
     */
    public function register(Request $request)
    {
        
        $validated = $request->validate([
            'fullname' => [
                'required',
                'string',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
                'unique:users,phone',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'fullname.required' => 'يرجى إدخال الاسم الكامل.',
            'fullname.string' => 'الاسم يجب أن يكون نصاً.',

            'phone.required' => 'يرجى إدخال رقم الموبايل.',
            'phone.unique' => 'رقم الموبايل مستخدم مسبقاً.',

            'password.required' => 'يرجى إدخال كلمة المرور.',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        // توليد Username فريد
        $username = $this->generateUniqueUsername();

        // إنشاء المستخدم
        $user = User::create([
            'fullname' => $validated['fullname'],
            'username' => $username,
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        // تسجيل الدخول مباشرة بعد إنشاء الحساب
        Auth::login($user);

        // تجديد الجلسة للحماية
        $request->session()->regenerate();

        // الانتقال إلى Dashboard
        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                "تم إنشاء الحساب بنجاح. اسم المستخدم الخاص بك هو: {$username}"
            );
    }

    /**
     * عرض صفحة تسجيل الدخول
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * تنفيذ تسجيل الدخول باستخدام Username + Password
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
            ],
        ], [
            'username.required' => 'يرجى إدخال اسم المستخدم.',

            'password.required' => 'يرجى إدخال كلمة المرور.',
        ]);

        // هل يريد المستخدم تذكر تسجيل الدخول؟
        $remember = $request->boolean('remember');

        // التحقق من Username + Password
        if (Auth::attempt($credentials, $remember)) {

            // تجديد الجلسة بعد نجاح تسجيل الدخول
            $request->session()->regenerate();

            return redirect()
                ->intended(route('dashboard'))
                ->with('success', 'تم تسجيل الدخول بنجاح.');
        }

        // بيانات الدخول غير صحيحة
        throw ValidationException::withMessages([
            'username' => 'اسم المستخدم أو كلمة المرور غير صحيحة.',
        ]);
    }

    /**
     * تسجيل الخروج
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // إلغاء الجلسة الحالية
        $request->session()->invalidate();

        // إنشاء CSRF Token جديد
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}