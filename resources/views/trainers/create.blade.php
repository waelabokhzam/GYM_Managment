@extends('layout.app')

@section('title', 'إضافة مدرب')

@section('page-title', 'إضافة مدرب')

@section('content')

<div class="mx-auto max-w-4xl">

    <div class="mb-6">

        <a
            href="{{ route('trainers.index') }}"
            class="
                inline-flex
                items-center
                gap-2
                text-sm
                text-[var(--color-text-muted)]
                transition
                hover:text-[#D46417]
            "
        >
            <i class="fa-solid fa-arrow-right"></i>
            العودة إلى المدربين
        </a>

    </div>


    <div
        class="
            overflow-hidden
            rounded-2xl
            border
            border-[var(--color-border)]
            bg-[var(--color-surface)]
        "
    >

        <div class="border-b border-[var(--color-border)] p-6">

            <h2 class="text-lg font-extrabold">
                إضافة مدرب جديد
            </h2>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                سيتم إنشاء حساب مستخدم للمدرب تلقائياً.
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('trainers.store') }}"
            class="space-y-6 p-6"
        >

            @csrf


            {{-- Personal Information --}}

            <div>

                <h3 class="mb-4 text-sm font-extrabold text-[#D46417]">
                    <i class="fa-solid fa-user ml-2"></i>
                    المعلومات الشخصية
                </h3>

                <div class="grid gap-5 md:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            الاسم الكامل
                        </label>

                        <input
                            type="text"
                            name="fullname"
                            value="{{ old('fullname') }}"
                            required
                            class="form-input"
                            placeholder="أدخل اسم المدرب"
                        >

                        @error('fullname')
                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            رقم الهاتف
                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            required
                            class="form-input"
                            placeholder="09xxxxxxxx"
                        >

                        @error('phone')
                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- Login --}}

            <div>

                <h3 class="mb-4 text-sm font-extrabold text-[#D46417]">
                    <i class="fa-solid fa-lock ml-2"></i>
                    بيانات الدخول
                </h3>

                <div class="grid gap-5 md:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            كلمة المرور
                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            class="form-input"
                            placeholder="••••••••"
                        >

                        @error('password')
                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            تأكيد كلمة المرور
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            class="form-input"
                            placeholder="••••••••"
                        >

                    </div>

                </div>

                <p class="mt-3 text-xs text-[var(--color-text-muted)]">
                    سيتم إنشاء اسم المستخدم تلقائياً من النظام.
                </p>

            </div>


            {{-- Salary --}}

            <div>

                <h3 class="mb-4 text-sm font-extrabold text-[#D46417]">
                    <i class="fa-solid fa-money-bill-wave ml-2"></i>
                    نظام الأجر
                </h3>

                <div class="grid gap-5 md:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            نوع الأجر
                        </label>

                        <select
                            name="salary_type"
                            id="salary_type"
                            required
                            class="form-input"
                        >

                            <option value="">
                                اختر نوع الأجر
                            </option>

                            <option
                                value="fixed"
                                @selected(old('salary_type') === 'fixed')
                            >
                                راتب ثابت
                            </option>

                            <option
                                value="percentage"
                                @selected(old('salary_type') === 'percentage')
                            >
                                نسبة
                            </option>

                        </select>

                        @error('salary_type')
                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            القيمة
                        </label>

                        <div class="relative">

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="base_salary"
                                value="{{ old('base_salary') }}"
                                class="form-input pl-12"
                                placeholder="0.00"
                            >

                            <span
                                class="
                                    absolute
                                    left-4
                                    top-1/2
                                    -translate-y-1/2
                                    text-xs
                                    text-[var(--color-text-muted)]
                                "
                            >
                                <span id="salary-unit">
                                    $
                                </span>
                            </span>

                        </div>

                        @error('base_salary')
                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- Actions --}}

            <div
                class="
                    flex
                    flex-col-reverse
                    gap-3
                    border-t
                    border-[var(--color-border)]
                    pt-6
                    sm:flex-row
                    sm:justify-end
                "
            >

                <a
                    href="{{ route('trainers.index') }}"
                    class="
                        rounded-xl
                        border
                        border-[var(--color-border)]
                        px-6
                        py-3
                        text-center
                        text-sm
                        font-bold
                        transition
                        hover:border-[#D46417]
                    "
                >
                    إلغاء
                </a>

                <button
                    type="submit"
                    class="
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
                        hover:bg-[#b95412]
                    "
                >
                    <i class="fa-solid fa-plus ml-2"></i>
                    إنشاء المدرب
                </button>

            </div>

        </form>

    </div>

</div>


@push('styles')

<style>

    .form-input {
        width: 100%;
        border-radius: 0.75rem;
        border: 1px solid var(--color-border);
        background: var(--color-background);
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: var(--color-text);
        outline: none;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        border-color: #D46417;
        box-shadow: 0 0 0 3px rgba(212, 100, 23, 0.10);
    }

    .form-input::placeholder {
        color: var(--color-text-muted);
    }

</style>

@endpush


@push('scripts')

<script>

    const salaryType =
        document.getElementById('salary_type');

    const salaryUnit =
        document.getElementById('salary-unit');


    salaryType?.addEventListener('change', function () {

        salaryUnit.textContent =
            this.value === 'percentage'
                ? '%'
                : '$';

    });


    salaryType?.dispatchEvent(
        new Event('change')
    );

</script>

@endpush

@endsection