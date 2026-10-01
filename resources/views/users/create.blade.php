@extends('layout.app')

@section('title', 'إضافة مستخدم')
@section('page-title', 'إضافة مستخدم')

@section('content')

<div class="mx-auto max-w-5xl">

    <div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

        {{-- Header --}}
        <div class="mb-8">

            <h2 class="text-xl font-extrabold">
                إضافة مستخدم جديد
            </h2>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                إنشاء حساب جديد وتحديد صلاحياته وبياناته
            </p>

        </div>


        {{-- Errors --}}
        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-400">

                <ul class="list-inside list-disc space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('users.store') }}"
            class="space-y-8"
        >

            @csrf


            {{-- Basic information --}}
            <div>

                <h3 class="mb-4 text-lg font-bold">
                    المعلومات الأساسية
                </h3>

                <div class="grid gap-5 md:grid-cols-2">


                    {{-- Fullname --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            الاسم الكامل
                        </label>

                        <input
                            type="text"
                            name="fullname"
                            value="{{ old('fullname') }}"
                            required
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3 text-sm
                                   outline-none focus:border-[#D46417]
                                   focus:ring-2 focus:ring-[#D46417]/10"
                        >

                    </div>


                    {{-- Phone --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            رقم الهاتف
                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            required
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3 text-sm
                                   outline-none focus:border-[#D46417]"
                        >

                    </div>


                    {{-- Dynamic Role --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            الدور
                        </label>

                        <select
                            name="role"
                            id="role"
                            required
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3 text-sm
                                   outline-none focus:border-[#D46417]"
                        >

                            <option value="">
                                اختر الدور
                            </option>

                            @foreach ($roles as $role)

                                <option
                                    value="{{ $role->name }}"
                                    @selected(old('role') === $role->name)
                                >
                                    {{ $role->name }}
                                </option>

                            @endforeach

                        </select>

                        @if($roles->isEmpty())

                            <p class="mt-2 text-xs text-red-400">
                                لا توجد أدوار متاحة حالياً.
                            </p>

                        @endif

                    </div>


                    {{-- Password --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            كلمة المرور
                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3 text-sm
                                   outline-none focus:border-[#D46417]"
                        >

                    </div>


                    {{-- Password Confirmation --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            تأكيد كلمة المرور
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3 text-sm
                                   outline-none focus:border-[#D46417]"
                        >

                    </div>

                </div>


                <div class="mt-4 rounded-xl bg-[var(--color-background)] p-4 text-sm text-[var(--color-text-muted)]">

                    <i class="fa-solid fa-circle-info ml-1"></i>

                    اسم المستخدم سيتم توليده تلقائيًا من النظام.

                </div>

            </div>


            {{-- Staff --}}
            <div
                id="staff-section"
                class="hidden border-t border-[var(--color-border)] pt-8"
            >

                <h3 class="mb-4 text-lg font-bold">
                    بيانات الموظف
                </h3>

                <div class="grid gap-5 md:grid-cols-2">


                    {{-- Salary Type --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            نوع الأجر
                        </label>

                        <select
                            name="salary_type"
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
                        >

                            <option
                                value="fixed"
                                @selected(old('salary_type', 'fixed') === 'fixed')
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

                    </div>


                    {{-- Base Salary --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            الأجر الأساسي
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="base_salary"
                            value="{{ old('base_salary') }}"
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
                        >

                    </div>

                </div>

            </div>


            {{-- Player --}}
            <div
                id="player-section"
                class="hidden border-t border-[var(--color-border)] pt-8"
            >

                <h3 class="mb-4 text-lg font-bold">
                    بيانات اللاعب
                </h3>

                <div class="grid gap-5 md:grid-cols-2">


                    {{-- Unique Number --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            الرقم الخاص
                        </label>

                        <input
                            type="text"
                            name="unique_number"
                            value="{{ old('unique_number') }}"
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
                        >

                    </div>


                    {{-- Gender --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            الجنس
                        </label>

                        <select
                            name="gender"
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
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

                    </div>


                    {{-- Height --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            الطول
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="height"
                            value="{{ old('height') }}"
                            placeholder="سم"
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
                        >

                    </div>


                    {{-- Weight --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            الوزن
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="weight"
                            value="{{ old('weight') }}"
                            placeholder="كغ"
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
                        >

                    </div>


                    {{-- Occupation --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            المهنة
                        </label>

                        <input
                            type="text"
                            name="occupation"
                            value="{{ old('occupation') }}"
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
                        >

                    </div>


                    {{-- Health --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            الحالة الصحية
                        </label>

                        <textarea
                            name="health_status"
                            rows="3"
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
                        >{{ old('health_status') }}</textarea>

                    </div>

                </div>

            </div>


            {{-- Actions --}}
            <div class="flex justify-end gap-3 border-t border-[var(--color-border)] pt-6">

                <a
                    href="{{ route('users.index') }}"
                    class="rounded-xl border border-[var(--color-border)]
                           px-6 py-3 text-sm font-bold"
                >
                    إلغاء
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-[#D46417] px-6 py-3
                           text-sm font-bold text-white
                           hover:bg-[#b95412]"
                >
                    حفظ المستخدم
                </button>

            </div>

        </form>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const roleSelect = document.getElementById('role');

    const staffSection = document.getElementById('staff-section');
    const playerSection = document.getElementById('player-section');

    function toggleRoleSections() {

        const role = roleSelect.value;

        /*
        |--------------------------------------------------------------------------
        | إخفاء كل الأقسام
        |--------------------------------------------------------------------------
        */

        staffSection.classList.add('hidden');
        playerSection.classList.add('hidden');


        /*
        |--------------------------------------------------------------------------
        | Player
        |--------------------------------------------------------------------------
        */

        if (role === 'player') {

            playerSection.classList.remove('hidden');

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | أي Role آخر يعتبر Staff
        |--------------------------------------------------------------------------
        */

        if (role !== '') {

            staffSection.classList.remove('hidden');

        }

    }

    roleSelect.addEventListener('change', toggleRoleSections);

    toggleRoleSections();

});

</script>

@endsection