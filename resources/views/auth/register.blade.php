<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>


<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    إنشاء حساب | نظام إدارة النادي
</title>

@vite([
    'resources/css/app.css',
    'resources/js/app.js'
])


</head>

<body class="min-h-screen bg-[var(--color-background)] text-[var(--color-text)]">

<div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-8">


{{-- Background --}}

<div
    class="
        absolute
        -right-40
        -top-40
        h-96
        w-96
        rounded-full
        bg-[#D46417]/10
        blur-3xl
    "
></div>

<div
    class="
        absolute
        -bottom-40
        -left-40
        h-96
        w-96
        rounded-full
        bg-[#D46417]/5
        blur-3xl
    "
></div>


{{-- Register Card --}}

<div
    class="
        relative
        z-10
        w-full
        max-w-md
        rounded-3xl
        border
        border-[var(--color-border)]
        bg-[var(--color-surface)]
        p-6
        shadow-2xl
        sm:p-10
    "
>

    {{-- Logo --}}

    <div class="mb-7 text-center">

        <div
            class="
                mx-auto
                mb-4
                flex
                h-16
                w-16
                items-center
                justify-center
                rounded-2xl
                bg-[#D46417]
                text-2xl
                text-white
                shadow-xl
                shadow-[#D46417]/20
            "
        >

            <i class="fa-solid fa-dumbbell"></i>

        </div>

        <h1 class="text-2xl font-extrabold">

            GYM

            <span class="text-[#D46417]">
                MANAGEMENT
            </span>

        </h1>

        <p class="mt-1 text-xs text-[var(--color-text-muted)]">
            إنشاء حساب جديد في نظام إدارة النادي
        </p>

    </div>


    {{-- Errors --}}

    @if ($errors->any())

        <div
            class="
                mb-5
                rounded-xl
                border
                border-red-500/20
                bg-red-500/10
                p-3
                text-xs
                text-red-400
            "
        >

            @foreach ($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    {{-- Form --}}

    <form
        method="POST"
        action="{{ route('register') }}"
        class="space-y-4"
    >

        @csrf


        {{-- Full Name --}}

        <div>

            <label
                for="name"
                class="mb-2 block text-sm font-bold"
            >
                الاسم الكامل
            </label>

            <div class="relative">

                <i
                    class="
                        fa-solid
                        fa-user
                        absolute
                        right-4
                        top-1/2
                        -translate-y-1/2
                        text-[#D46417]
                    "
                ></i>

                <input
                    type="text"
                    id="name"
                    name="fullname"
                    value="{{ old('fullname') }}"
                    placeholder="أدخل الاسم الكامل"
                    autocomplete="name"
                    required
                    autofocus
                    class="
                        h-12
                        w-full
                        rounded-xl
                        border
                        border-[var(--color-border)]
                        bg-[var(--color-background)]
                        px-4
                        pr-11
                        text-sm
                        text-[var(--color-text)]
                        outline-none
                        transition
                        placeholder:text-[var(--color-text-muted)]
                        focus:border-[#D46417]
                        focus:ring-2
                        focus:ring-[#D46417]/10
                    "
                >

            </div>

            @error('fullname')

                <p class="mt-1 text-xs text-red-400">
                    {{ $message }}
                </p>

            @enderror

        </div>

        {{-- Mobile --}}

        <div>

            <label
                for="phone"
                class="mb-2 block text-sm font-bold"
            >
                رقم الموبايل
            </label>

            <div class="relative">

                <i
                    class="
                        fa-solid
                        fa-phone
                        absolute
                        right-4
                        top-1/2
                        -translate-y-1/2
                        text-[#D46417]
                    "
                ></i>

                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="مثال: 09XXXXXXXX"
                    autocomplete="tel"
                    required
                    class="
                        h-12
                        w-full
                        rounded-xl
                        border
                        border-[var(--color-border)]
                        bg-[var(--color-background)]
                        px-4
                        pr-11
                        text-sm
                        text-[var(--color-text)]
                        outline-none
                        transition
                        placeholder:text-[var(--color-text-muted)]
                        focus:border-[#D46417]
                        focus:ring-2
                        focus:ring-[#D46417]/10
                    "
                >

            </div>

            @error('phone')

                <p class="mt-1 text-xs text-red-400">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Password --}}

        <div>

            <label
                for="password"
                class="mb-2 block text-sm font-bold"
            >
                كلمة المرور
            </label>

            <div class="relative">

                <i
                    class="
                        fa-solid
                        fa-lock
                        absolute
                        right-4
                        top-1/2
                        -translate-y-1/2
                        text-[#D46417]
                    "
                ></i>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="أدخل كلمة المرور"
                    autocomplete="new-password"
                    required
                    class="
                        h-12
                        w-full
                        rounded-xl
                        border
                        border-[var(--color-border)]
                        bg-[var(--color-background)]
                        px-4
                        pl-12
                        pr-11
                        text-sm
                        text-[var(--color-text)]
                        outline-none
                        transition
                        placeholder:text-[var(--color-text-muted)]
                        focus:border-[#D46417]
                        focus:ring-2
                        focus:ring-[#D46417]/10
                    "
                >

                <button
                    type="button"
                    id="password-toggle"
                    class="
                        absolute
                        left-4
                        top-1/2
                        -translate-y-1/2
                        text-[var(--color-text-muted)]
                        transition
                        hover:text-[#D46417]
                    "
                >

                    <i class="fa-solid fa-eye"></i>

                </button>

            </div>

            @error('password')

                <p class="mt-1 text-xs text-red-400">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Confirm Password --}}

        <div>

            <label
                for="password_confirmation"
                class="mb-2 block text-sm font-bold"
            >
                تأكيد كلمة المرور
            </label>

            <div class="relative">

                <i
                    class="
                        fa-solid
                        fa-lock
                        absolute
                        right-4
                        top-1/2
                        -translate-y-1/2
                        text-[#D46417]
                    "
                ></i>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="أعد إدخال كلمة المرور"
                    autocomplete="new-password"
                    required
                    class="
                        h-12
                        w-full
                        rounded-xl
                        border
                        border-[var(--color-border)]
                        bg-[var(--color-background)]
                        px-4
                        pl-12
                        pr-11
                        text-sm
                        text-[var(--color-text)]
                        outline-none
                        transition
                        placeholder:text-[var(--color-text-muted)]
                        focus:border-[#D46417]
                        focus:ring-2
                        focus:ring-[#D46417]/10
                    "
                >

                <button
                    type="button"
                    id="password-confirmation-toggle"
                    class="
                        absolute
                        left-4
                        top-1/2
                        -translate-y-1/2
                        text-[var(--color-text-muted)]
                        transition
                        hover:text-[#D46417]
                    "
                >

                    <i class="fa-solid fa-eye"></i>

                </button>

            </div>

            @error('password_confirmation')

                <p class="mt-1 text-xs text-red-400">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Submit --}}

        <button
            type="submit"
            class="
                mt-2
                flex
                h-12
                w-full
                items-center
                justify-center
                gap-2
                rounded-xl
                bg-[#D46417]
                text-sm
                font-extrabold
                text-white
                shadow-lg
                shadow-[#D46417]/20
                transition
                hover:-translate-y-0.5
                hover:bg-[#D46417]/90
            "
        >

            <i class="fa-solid fa-user-plus"></i>

            إنشاء الحساب

        </button>

    </form>


    {{-- Login Link --}}

    <div
        class="
            mt-6
            border-t
            border-[var(--color-border)]
            pt-5
            text-center
        "
    >

        <p class="text-xs text-[var(--color-text-muted)]">

            لديك حساب بالفعل؟

            <a
                href="{{ route('login') }}"
                class="
                    mr-1
                    font-bold
                    text-[#D46417]
                    transition
                    hover:text-[#D46417]/80
                "
            >
                تسجيل الدخول
            </a>

        </p>

    </div>


    <p class="mt-5 text-center text-[10px] text-[var(--color-text-muted)]">
        نظام إدارة النادي الرياضي
    </p>

</div>


</div>

<script>

    /*
    |--------------------------------------------------------------------------
    | Password Toggle
    |--------------------------------------------------------------------------
    */

    const password =
        document.getElementById('password');

    const passwordToggle =
        document.getElementById('password-toggle');


    passwordToggle?.addEventListener('click', () => {

        const visible =
            password.type === 'text';

        password.type =
            visible ? 'password' : 'text';

        passwordToggle.innerHTML =
            visible
                ? '<i class="fa-solid fa-eye"></i>'
                : '<i class="fa-solid fa-eye-slash"></i>';

    });


    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Toggle
    |--------------------------------------------------------------------------
    */

    const passwordConfirmation =
        document.getElementById('password_confirmation');

    const passwordConfirmationToggle =
        document.getElementById('password-confirmation-toggle');


    passwordConfirmationToggle?.addEventListener('click', () => {

        const visible =
            passwordConfirmation.type === 'text';

        passwordConfirmation.type =
            visible ? 'password' : 'text';

        passwordConfirmationToggle.innerHTML =
            visible
                ? '<i class="fa-solid fa-eye"></i>'
                : '<i class="fa-solid fa-eye-slash"></i>';

    });

</script>

</body>
</html>
