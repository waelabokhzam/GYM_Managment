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

    private function generateUniqueUsername(): string
    {
        do {
            $username = 'gym_' . strtoupper(
                substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6)
            );
        } while (User::where('username', $username)->exists());

        return $username;
    }
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
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
            'name.required' => 'يرجى إدخال الاسم الكامل.',
            'name.string' => 'الاسم يجب أن يكون نصاً.',
            'name.max' => 'الاسم طويل جداً.',

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
            'name' => $validated['name'],
            'username' => $username,
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        // تسجيل الدخول مباشرة
        Auth::login($user);

        // تجديد الجلسة
        $request->session()->regenerate();

        // التوجه للداشبورد مع إرسال الـ username
        return redirect()
            ->route('dashboard')
            ->with('success', "تم إنشاء الحساب بنجاح. اسم المستخدم الخاص بك هو: {$username}");
    }
    /**
     * عرض صفحة تسجيل الدخول
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * تنفيذ تسجيل الدخول
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ], [
            'email.required'    => 'يرجى إدخال البريد الإلكتروني.',
            'email.email'       => 'يرجى إدخال بريد إلكتروني صحيح.',

            'password.required' => 'يرجى إدخال كلمة المرور.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {

            $request->session()->regenerate();

            return redirect()
                ->intended(route('dashboard'))
                ->with('success', 'تم تسجيل الدخول بنجاح.');
        }

        throw ValidationException::withMessages([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ]);
    }

    /**
     * تسجيل الخروج
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}
