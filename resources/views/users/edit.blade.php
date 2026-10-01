@extends('layout.app')

@section('title', 'تعديل المستخدم')
@section('page-title', 'تعديل المستخدم')

@section('content')

@php
    $currentRole = $user->roles->first()?->name;
@endphp

<div class="mx-auto max-w-5xl">

    <div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

        {{-- Header --}}
        <div class="mb-8">

            <h2 class="text-xl font-extrabold">
                تعديل المستخدم
            </h2>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                تعديل بيانات الحساب والدور والبيانات المرتبطة به
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
            action="{{ route('users.update', $user) }}"
            class="space-y-8"
        >

            @csrf
            @method('PUT')


            {{-- Basic --}}
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
                            value="{{ old('fullname', $user->fullname) }}"
                            required
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
                        >

                    </div>


                    {{-- Username --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            اسم المستخدم
                        </label>

                        <input
                            type="text"
                            value="{{ $user->username }}"
                            disabled
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3 opacity-60"
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
                            value="{{ old('phone', $user->phone) }}"
                            required
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
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
                                   bg-[var(--color-background)] px-4 py-3"
                        >

                            <option value="">
                                اختر الدور
                            </option>

                            @foreach ($roles as $role)

                                <option
                                    value="{{ $role->name }}"
                                    @selected(
                                        old('role', $currentRole) === $role->name
                                    )
                                >
                                    {{ $role->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Password --}}
                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            كلمة مرور جديدة
                        </label>

                        <input
                            type="password"
                            name="password"
                            placeholder="اتركها فارغة إذا لم ترد تغييرها"
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
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
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
                        >

                    </div>

                </div>

            </div>


            {{-- Staff --}}
            <div
                id="staff-section"
                class="{{ $currentRole && $currentRole !== 'player' ? '' : 'hidden' }}
                       border-t border-[var(--color-border)] pt-8"
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
                                @selected(
                                    old(
                                        'salary_type',
                                        $user->staff?->salary_type
                                    ) === 'fixed'
                                )
                            >
                                راتب ثابت
                            </option>

                            <option
                                value="percentage"
                                @selected(
                                    old(
                                        'salary_type',
                                        $user->staff?->salary_type
                                    ) === 'percentage'
                                )
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
                            value="{{ old('base_salary', $user->staff?->base_salary) }}"
                            class="w-full rounded-xl border border-[var(--color-border)]
                                   bg-[var(--color-background)] px-4 py-3"
                        >

                    </div>

                </div>

            </div>


            {{-- Player --}}
            <div
                id="player-section"
                class="{{ $currentRole === 'player' ? '' : 'hidden' }}
                       border-t border-[var(--color-border)] pt-8"
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
                            readonly
                            name="unique_number"
                            value="{{ old('unique_number', $user->player?->unique_number) }}"
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
                                @selected(
                                    old(
                                        'gender',
                                        $user->player?->gender
                                    ) === 'male'
                                )
                            >
                                ذكر
                            </option>

                            <option
                                value="female"
                                @selected(
                                    old(
                                        'gender',
                                        $user->player?->gender
                                    ) === 'female'
                                )
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
                            value="{{ old('height', $user->player?->height) }}"
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
                            value="{{ old('weight', $user->player?->weight) }}"
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
                            value="{{ old('occupation', $user->player?->occupation) }}"
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
                        >{{ old('health_status', $user->player?->health_status) }}</textarea>

                    </div>

                </div>

            </div>


            {{-- Actions --}}
            <div class="flex justify-end gap-3 border-t border-[var(--color-border)] pt-6">

                <a
                    href="{{ route('users.index') }}"
                    class="rounded-xl border border-[var(--color-border)]
                           px-6 py-3 font-bold"
                >
                    إلغاء
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-[#D46417] px-6 py-3
                           font-bold text-white hover:bg-[#b95412]"
                >
                    حفظ التعديلات
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
        | إخفاء الأقسام
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
        | أي Role آخر = Staff
        |--------------------------------------------------------------------------
        */

        if (role !== '') {

            staffSection.classList.remove('hidden');

        }

    }


    roleSelect.addEventListener(
        'change',
        toggleRoleSections
    );


    toggleRoleSections();

});

</script>

@endsection