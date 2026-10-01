@extends('layout.app')

@section('title', 'إضافة لاعب')

@section('page-title', 'إضافة لاعب')

@section('content')

<div class="mb-6">

    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-extrabold tracking-tight sm:text-3xl">
                إضافة لاعب جديد
            </h1>

            <p class="mt-2 text-sm text-[var(--color-text-muted)] sm:text-base">
                إنشاء حساب لاعب وإضافة بياناته الأساسية إلى النظام.
            </p>
        </div>

        <a
            href="{{ route('players.index') }}"
            class="
                inline-flex
                items-center
                justify-center
                gap-2
                rounded-xl
                border
                border-[var(--color-border)]
                bg-[var(--color-surface)]
                px-4
                py-2.5
                text-sm
                font-semibold
                transition
                duration-300
                hover:border-[#D46417]
                hover:text-[#D46417]
            "
        >
            <i class="fa-solid fa-arrow-right"></i>
            العودة إلى اللاعبين
        </a>

    </div>

</div>


{{-- =====================================================
     Validation Errors
====================================================== --}}

@if ($errors->any())

    <div
        class="
            mb-6
            rounded-2xl
            border
            border-red-500/30
            bg-red-500/10
            p-4
            text-red-500
        "
    >

        <div class="flex items-start gap-3">

            <i class="fa-solid fa-circle-exclamation mt-0.5"></i>

            <div>

                <h3 class="font-bold">
                    يرجى تصحيح الأخطاء التالية:
                </h3>

                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        </div>

    </div>

@endif


{{-- =====================================================
     Create Player Form
====================================================== --}}

<form
    action="{{ route('players.store') }}"
    method="POST"
    class="space-y-6"
>

    @csrf


    {{-- =================================================
         Account Information
    ================================================== --}}

    <div
        class="
            overflow-hidden
            rounded-2xl
            border
            border-[var(--color-border)]
            bg-[var(--color-surface)]
        "
    >

        <div
            class="
                border-b
                border-[var(--color-border)]
                px-5
                py-4
                sm:px-6
            "
        >

            <div class="flex items-center gap-3">

                <div
                    class="
                        flex
                        h-10
                        w-10
                        items-center
                        justify-center
                        rounded-xl
                        bg-[#D46417]/15
                        text-[#D46417]
                    "
                >
                    <i class="fa-solid fa-user"></i>
                </div>

                <div>

                    <h2 class="font-bold">
                        بيانات الحساب
                    </h2>

                    <p class="mt-0.5 text-xs text-[var(--color-text-muted)]">
                        البيانات التي سيتم تخزينها في جدول المستخدمين.
                    </p>

                </div>

            </div>

        </div>


        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 sm:p-6">

            {{-- Full Name --}}

            <div>

                <label
                    for="fullname"
                    class="mb-2 block text-sm font-semibold"
                >
                    الاسم الكامل
                    <span class="text-[#D46417]">*</span>
                </label>

                <div class="relative">

                    <i
                        class="
                            fa-solid
                            fa-user
                            pointer-events-none
                            absolute
                            right-4
                            top-1/2
                            -translate-y-1/2
                            text-[var(--color-text-muted)]
                        "
                    ></i>

                    <input
                        type="text"
                        id="fullname"
                        name="fullname"
                        value="{{ old('fullname') }}"
                        required
                        autofocus
                        placeholder="أدخل الاسم الكامل"
                        class="
                            w-full
                            rounded-xl
                            border
                            border-[var(--color-border)]
                            bg-[var(--color-bg)]
                            py-3
                            pr-11
                            pl-4
                            text-sm
                            outline-none
                            transition
                            duration-300
                            focus:border-[#D46417]
                            focus:ring-2
                            focus:ring-[#D46417]/20
                        "
                    >

                </div>

                @error('fullname')
                    <p class="mt-1.5 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Phone --}}

            <div>

                <label
                    for="phone"
                    class="mb-2 block text-sm font-semibold"
                >
                    رقم الهاتف
                    <span class="text-[#D46417]">*</span>
                </label>

                <div class="relative">

                    <i
                        class="
                            fa-solid
                            fa-phone
                            pointer-events-none
                            absolute
                            right-4
                            top-1/2
                            -translate-y-1/2
                            text-[var(--color-text-muted)]
                        "
                    ></i>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        required
                        placeholder="مثال: 09xxxxxxxx"
                        class="
                            w-full
                            rounded-xl
                            border
                            border-[var(--color-border)]
                            bg-[var(--color-bg)]
                            py-3
                            pr-11
                            pl-4
                            text-sm
                            outline-none
                            transition
                            duration-300
                            focus:border-[#D46417]
                            focus:ring-2
                            focus:ring-[#D46417]/20
                        "
                    >

                </div>

                @error('phone')
                    <p class="mt-1.5 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Password --}}

            <div>

                <label
                    for="password"
                    class="mb-2 block text-sm font-semibold"
                >
                    كلمة المرور
                    <span class="text-[#D46417]">*</span>
                </label>

                <div class="relative">

                    <i
                        class="
                            fa-solid
                            fa-lock
                            pointer-events-none
                            absolute
                            right-4
                            top-1/2
                            -translate-y-1/2
                            text-[var(--color-text-muted)]
                        "
                    ></i>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        placeholder="أدخل كلمة المرور"
                        class="
                            w-full
                            rounded-xl
                            border
                            border-[var(--color-border)]
                            bg-[var(--color-bg)]
                            py-3
                            pr-11
                            pl-4
                            text-sm
                            outline-none
                            transition
                            duration-300
                            focus:border-[#D46417]
                            focus:ring-2
                            focus:ring-[#D46417]/20
                        "
                    >

                </div>

                @error('password')
                    <p class="mt-1.5 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Password Confirmation --}}

            <div>

                <label
                    for="password_confirmation"
                    class="mb-2 block text-sm font-semibold"
                >
                    تأكيد كلمة المرور
                    <span class="text-[#D46417]">*</span>
                </label>

                <div class="relative">

                    <i
                        class="
                            fa-solid
                            fa-lock
                            pointer-events-none
                            absolute
                            right-4
                            top-1/2
                            -translate-y-1/2
                            text-[var(--color-text-muted)]
                        "
                    ></i>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        placeholder="أعد كتابة كلمة المرور"
                        class="
                            w-full
                            rounded-xl
                            border
                            border-[var(--color-border)]
                            bg-[var(--color-bg)]
                            py-3
                            pr-11
                            pl-4
                            text-sm
                            outline-none
                            transition
                            duration-300
                            focus:border-[#D46417]
                            focus:ring-2
                            focus:ring-[#D46417]/20
                        "
                    >

                </div>

            </div>

        </div>

    </div>


    {{-- =================================================
         Player Information
    ================================================== --}}

    <div
        class="
            overflow-hidden
            rounded-2xl
            border
            border-[var(--color-border)]
            bg-[var(--color-surface)]
        "
    >

        <div
            class="
                border-b
                border-[var(--color-border)]
                px-5
                py-4
                sm:px-6
            "
        >

            <div class="flex items-center gap-3">

                <div
                    class="
                        flex
                        h-10
                        w-10
                        items-center
                        justify-center
                        rounded-xl
                        bg-[#D46417]/15
                        text-[#D46417]
                    "
                >
                    <i class="fa-solid fa-dumbbell"></i>
                </div>

                <div>

                    <h2 class="font-bold">
                        بيانات اللاعب
                    </h2>

                    <p class="mt-0.5 text-xs text-[var(--color-text-muted)]">
                        المعلومات الخاصة باللاعب التي سيتم تخزينها في جدول اللاعبين.
                    </p>

                </div>

            </div>

        </div>


        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3 sm:p-6">


            {{-- Gender --}}

            <div>

                <label
                    for="gender"
                    class="mb-2 block text-sm font-semibold"
                >
                    الجنس
                    <span class="text-[#D46417]">*</span>
                </label>

                <div class="relative">

                    <i
                        class="
                            fa-solid
                            fa-venus-mars
                            pointer-events-none
                            absolute
                            right-4
                            top-1/2
                            -translate-y-1/2
                            text-[var(--color-text-muted)]
                        "
                    ></i>

                    <select
                        id="gender"
                        name="gender"
                        required
                        class="
                            w-full
                            appearance-none
                            rounded-xl
                            border
                            border-[var(--color-border)]
                            bg-[var(--color-bg)]
                            py-3
                            pr-11
                            pl-10
                            text-sm
                            outline-none
                            transition
                            duration-300
                            focus:border-[#D46417]
                            focus:ring-2
                            focus:ring-[#D46417]/20
                        "
                    >

                        <option value="">
                            اختر الجنس
                        </option>

                        <option
                            value="male"
                            @selected(old('gender') === 'male')
                        >
                            ذكر
                        </option>

                        <option
                            value="female"
                            @selected(old('gender') === 'female')
                        >
                            أنثى
                        </option>

                    </select>

                    <i
                        class="
                            fa-solid
                            fa-chevron-down
                            pointer-events-none
                            absolute
                            left-4
                            top-1/2
                            -translate-y-1/2
                            text-xs
                            text-[var(--color-text-muted)]
                        "
                    ></i>

                </div>

                @error('gender')
                    <p class="mt-1.5 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Height --}}

            <div>

                <label
                    for="height"
                    class="mb-2 block text-sm font-semibold"
                >
                    الطول
                    <span class="text-xs font-normal text-[var(--color-text-muted)]">
                        (سم)
                    </span>
                </label>

                <div class="relative">

                    <i
                        class="
                            fa-solid
                            fa-ruler-vertical
                            pointer-events-none
                            absolute
                            right-4
                            top-1/2
                            -translate-y-1/2
                            text-[var(--color-text-muted)]
                        "
                    ></i>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        id="height"
                        name="height"
                        value="{{ old('height') }}"
                        placeholder="مثال: 175"
                        class="
                            w-full
                            rounded-xl
                            border
                            border-[var(--color-border)]
                            bg-[var(--color-bg)]
                            py-3
                            pr-11
                            pl-4
                            text-sm
                            outline-none
                            transition
                            duration-300
                            focus:border-[#D46417]
                            focus:ring-2
                            focus:ring-[#D46417]/20
                        "
                    >

                </div>

                @error('height')
                    <p class="mt-1.5 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Weight --}}

            <div>

                <label
                    for="weight"
                    class="mb-2 block text-sm font-semibold"
                >
                    الوزن
                    <span class="text-xs font-normal text-[var(--color-text-muted)]">
                        (كغ)
                    </span>
                </label>

                <div class="relative">

                    <i
                        class="
                            fa-solid
                            fa-weight-scale
                            pointer-events-none
                            absolute
                            right-4
                            top-1/2
                            -translate-y-1/2
                            text-[var(--color-text-muted)]
                        "
                    ></i>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        id="weight"
                        name="weight"
                        value="{{ old('weight') }}"
                        placeholder="مثال: 75"
                        class="
                            w-full
                            rounded-xl
                            border
                            border-[var(--color-border)]
                            bg-[var(--color-bg)]
                            py-3
                            pr-11
                            pl-4
                            text-sm
                            outline-none
                            transition
                            duration-300
                            focus:border-[#D46417]
                            focus:ring-2
                            focus:ring-[#D46417]/20
                        "
                    >

                </div>

                @error('weight')
                    <p class="mt-1.5 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Occupation --}}

            <div>

                <label
                    for="occupation"
                    class="mb-2 block text-sm font-semibold"
                >
                    المهنة
                </label>

                <div class="relative">

                    <i
                        class="
                            fa-solid
                            fa-briefcase
                            pointer-events-none
                            absolute
                            right-4
                            top-1/2
                            -translate-y-1/2
                            text-[var(--color-text-muted)]
                        "
                    ></i>

                    <input
                        type="text"
                        id="occupation"
                        name="occupation"
                        value="{{ old('occupation') }}"
                        placeholder="مثال: مهندس"
                        class="
                            w-full
                            rounded-xl
                            border
                            border-[var(--color-border)]
                            bg-[var(--color-bg)]
                            py-3
                            pr-11
                            pl-4
                            text-sm
                            outline-none
                            transition
                            duration-300
                            focus:border-[#D46417]
                            focus:ring-2
                            focus:ring-[#D46417]/20
                        "
                    >

                </div>

                @error('occupation')
                    <p class="mt-1.5 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Health Status --}}

            <div class="sm:col-span-2 lg:col-span-3">

                <label
                    for="health_status"
                    class="mb-2 block text-sm font-semibold"
                >
                    الحالة الصحية
                </label>

                <textarea
                    id="health_status"
                    name="health_status"
                    rows="4"
                    placeholder="أدخل أي معلومات صحية مهمة..."
                    class="
                        w-full
                        resize-none
                        rounded-xl
                        border
                        border-[var(--color-border)]
                        bg-[var(--color-bg)]
                        px-4
                        py-3
                        text-sm
                        outline-none
                        transition
                        duration-300
                        focus:border-[#D46417]
                        focus:ring-2
                        focus:ring-[#D46417]/20
                    "
                >{{ old('health_status') }}</textarea>

                @error('health_status')
                    <p class="mt-1.5 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>

        </div>

    </div>


    {{-- =================================================
         Information Notice
    ================================================== --}}

    <div
        class="
            flex
            items-start
            gap-3
            rounded-2xl
            border
            border-[#D46417]/20
            bg-[#D46417]/5
            p-4
            text-sm
        "
    >

        <i class="fa-solid fa-circle-info mt-0.5 text-[#D46417]"></i>

        <div class="text-[var(--color-text-muted)]">

            <p class="font-semibold text-[var(--color-text)]">
                معلومات الحساب
            </p>

            <p class="mt-1">
                سيتم إنشاء اسم مستخدم تلقائياً للاعب يبدأ بـ
                <span class="font-bold text-[#D46417]">gym_</span>
                ولن يتم إدخاله يدوياً.
            </p>

        </div>

    </div>


    {{-- =================================================
         Actions
    ================================================== --}}

    <div
        class="
            flex
            flex-col-reverse
            gap-3
            sm:flex-row
            sm:justify-end
        "
    >

        <a
            href="{{ route('players.index') }}"
            class="
                inline-flex
                items-center
                justify-center
                gap-2
                rounded-xl
                border
                border-[var(--color-border)]
                px-6
                py-3
                text-sm
                font-bold
                transition
                duration-300
                hover:border-[#D46417]
                hover:text-[#D46417]
            "
        >
            إلغاء
        </a>

        <button
            type="submit"
            class="
                inline-flex
                items-center
                justify-center
                gap-2
                rounded-xl
                bg-[#D46417]
                px-6
                py-3
                text-sm
                font-bold
                text-white
                shadow-lg
                shadow-[#D46417]/20
                transition
                duration-300
                hover:-translate-y-0.5
                hover:bg-[#b95512]
            "
        >
            <i class="fa-solid fa-user-plus"></i>
            إنشاء اللاعب
        </button>

    </div>

</form>

@endsection