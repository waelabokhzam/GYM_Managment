@extends('layout.app')

@section('title', 'إضافة فترة زمنية')
@section('page-title', 'إضافة فترة زمنية')

@section('content')
    <div class="mx-auto max-w-3xl">

        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('timeslots.index') }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"
                title="العودة">
                <i class="fa-solid fa-arrow-right"></i>
            </a>

            <div>
                <h2 class="text-xl font-extrabold">إضافة فترة زمنية</h2>
                <p class="text-sm text-[var(--color-text-muted)]">
                    حدد اسم الفترة ووقتها ونوعها والأيام التي تعمل فيها.
                </p>
            </div>
        </div>

        <form method="POST"
            action="{{ route('timeslots.store') }}"
            class="space-y-6 rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 sm:p-7">

            @csrf

            @if ($errors->any())
                <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
                    <p class="font-bold">يرجى مراجعة البيانات التالية:</p>

                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- اسم الفترة --}}
            <div>
                <label for="name" class="mb-2 block text-sm font-bold">
                    اسم الفترة
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    placeholder="مثال: الفترة الصباحية"
                    required
                    autofocus
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-text)] outline-none transition focus:border-[#D46417]"
                >

                @error('name')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- الأوقات --}}
            <div class="grid gap-5 sm:grid-cols-2">

                <div>
                    <label for="start_time" class="mb-2 block text-sm font-bold">
                        وقت البداية
                    </label>

                    <input
                        id="start_time"
                        name="start_time"
                        type="time"
                        value="{{ old('start_time') }}"
                        required
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-text)] outline-none transition focus:border-[#D46417]"
                    >

                    @error('start_time')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_time" class="mb-2 block text-sm font-bold">
                        وقت النهاية
                    </label>

                    <input
                        id="end_time"
                        name="end_time"
                        type="time"
                        value="{{ old('end_time') }}"
                        required
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-text)] outline-none transition focus:border-[#D46417]"
                    >

                    @error('end_time')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- نوع الفترة --}}
            <div>
                <span class="mb-3 block text-sm font-bold">
                    نوع الفترة
                </span>

                <div class="grid gap-3 sm:grid-cols-2">

                    <label
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-4 transition has-[:checked]:border-[#D46417] has-[:checked]:bg-[#D46417]/10">

                        <input
                            type="radio"
                            name="gender_type"
                            value="mixed"
                            @checked(old('gender_type', 'mixed') === 'mixed')
                            class="accent-[#D46417]"
                        >

                        <span>
                            <strong class="block text-sm">
                                فترة مختلطة
                            </strong>

                            <small class="text-xs text-[var(--color-text-muted)]">
                                مناسبة للجميع
                            </small>
                        </span>

                    </label>

                    <label
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-4 transition has-[:checked]:border-[#D46417] has-[:checked]:bg-[#D46417]/10">

                        <input
                            type="radio"
                            name="gender_type"
                            value="women_only"
                            @checked(old('gender_type') === 'women_only')
                            class="accent-[#D46417]"
                        >

                        <span>
                            <strong class="block text-sm">
                                نساء فقط
                            </strong>

                            <small class="text-xs text-[var(--color-text-muted)]">
                                مخصصة للسيدات
                            </small>
                        </span>

                    </label>

                </div>

                @error('gender_type')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- الأيام --}}
            <div>
                <div class="mb-3">
                    <span class="block text-sm font-bold">
                        تحديد الأيام
                    </span>

                    <span class="text-xs text-[var(--color-text-muted)]">
                        اختر الأيام التي تكون فيها هذه الفترة متاحة.
                    </span>
                </div>

                @php
                    $days = [
                        'saturday' => 'السبت',
                        'sunday' => 'الأحد',
                        'monday' => 'الإثنين',
                        'tuesday' => 'الثلاثاء',
                        'wednesday' => 'الأربعاء',
                        'thursday' => 'الخميس',
                        'friday' => 'الجمعة',
                    ];

                    $selectedDays = old('days', []);
                @endphp

                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">

                    @foreach ($days as $value => $label)
                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-4 transition has-[:checked]:border-[#D46417] has-[:checked]:bg-[#D46417]/10">

                            <input
                                type="checkbox"
                                name="days[]"
                                value="{{ $value }}"
                                @checked(in_array($value, $selectedDays))
                                class="h-4 w-4 accent-[#D46417]"
                            >

                            <span class="text-sm font-bold">
                                {{ $label }}
                            </span>

                        </label>
                    @endforeach

                </div>

                @error('days')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror

                @error('days.*')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- الأزرار --}}
            <div class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)] pt-5 sm:flex-row sm:justify-end">

                <a href="{{ route('timeslots.index') }}"
                    class="rounded-xl border border-[var(--color-border)] px-6 py-3 text-center text-sm font-bold text-[var(--color-text-muted)] transition hover:border-[#D46417]">
                    إلغاء
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-[#D46417] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#b95714]">

                    <i class="fa-solid fa-check me-2"></i>
                    حفظ الفترة

                </button>

            </div>

        </form>
    </div>
@endsection