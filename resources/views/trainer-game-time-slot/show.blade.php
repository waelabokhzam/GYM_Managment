@extends('layout.app')

@section('title', 'تفاصيل تعيين المدرب')
@section('page-title', 'تفاصيل تعيين المدرب')

@section('content')
    <div class="mx-auto max-w-4xl">

        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-3">

                <a href="{{ route('trainer-game-time-slots.index') }}"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"
                    title="العودة">

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

                <div>
                    <h2 class="text-xl font-extrabold">
                        تفاصيل التعيين
                    </h2>

                    <p class="text-sm text-[var(--color-text-muted)]">
                        معلومات المدرب واللعبة والفترة التدريبية.
                    </p>
                </div>

            </div>

            <a href="{{ route('trainer-game-time-slots.edit', $trainerGameTimeSlot) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-[var(--color-border)] px-5 py-3 text-sm font-bold text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]">

                <i class="fa-solid fa-pen-to-square"></i>

                تعديل التعيين

            </a>

        </div>

        @if (session('success'))
            <div
                class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm font-semibold text-emerald-400">

                <i class="fa-solid fa-circle-check me-2"></i>

                {{ session('success') }}

            </div>
        @endif

        {{-- Main Card --}}
        <article
            class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

            {{-- Top --}}
            <div
                class="border-b border-[var(--color-border)] bg-gradient-to-l from-[#D46417]/10 to-transparent p-6 sm:p-8">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                    <div
                        class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[#D46417]/15 text-2xl text-[#D46417]">

                        <i class="fa-solid fa-user-clock"></i>

                    </div>

                    <div class="min-w-0">

                        <span class="text-xs text-[var(--color-text-muted)]">
                            تعيين رقم #{{ $trainerGameTimeSlot->id }}
                        </span>

                        <h2 class="mt-1 text-2xl font-extrabold">
                            {{ $trainerGameTimeSlot->game?->name ?? 'لعبة غير محددة' }}
                        </h2>

                        <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                            مسؤولية المدرب ضمن الفترة التدريبية المحددة.
                        </p>

                    </div>

                </div>

            </div>

            {{-- Assignment Details --}}
            <div class="p-6 sm:p-8">

                <div class="grid gap-4 md:grid-cols-3">

                    {{-- Trainer --}}
                    <div
                        class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-background)] p-5">

                        <div class="mb-4 flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#D46417]/10 text-[#D46417]">

                                <i class="fa-solid fa-user-tie"></i>

                            </div>

                            <div>
                                <p class="text-[10px] text-[var(--color-text-muted)]">
                                    المدرب المسؤول
                                </p>

                                <h3 class="mt-1 text-sm font-bold">
                                    {{ $trainerGameTimeSlot->trainer?->user?->fullname ?? 'غير محدد' }}
                                </h3>
                            </div>

                        </div>

                        <div class="space-y-2 text-xs">

                            <div class="flex items-center justify-between gap-3">

                                <span class="text-[var(--color-text-muted)]">
                                    اسم المستخدم
                                </span>

                                <strong>
                                    {{ $trainerGameTimeSlot->trainer?->user?->username ?? '-' }}
                                </strong>

                            </div>

                            <div class="flex items-center justify-between gap-3">

                                <span class="text-[var(--color-text-muted)]">
                                    نوع الموظف
                                </span>

                                <span
                                    class="rounded-md bg-[#D46417]/10 px-2 py-1 font-bold text-[#D46417]">

                                    مدرب

                                </span>

                            </div>

                        </div>

                    </div>

                    {{-- Game --}}
                    <div
                        class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-background)] p-5">

                        <div class="mb-4 flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#D46417]/10 text-[#D46417]">

                                <i class="fa-solid fa-dumbbell"></i>

                            </div>

                            <div>

                                <p class="text-[10px] text-[var(--color-text-muted)]">
                                    اللعبة
                                </p>

                                <h3 class="mt-1 text-sm font-bold">
                                    {{ $trainerGameTimeSlot->game?->name ?? 'غير محددة' }}
                                </h3>

                            </div>

                        </div>

                        @if ($trainerGameTimeSlot->game?->description)

                            <p class="text-xs leading-6 text-[var(--color-text-muted)]">
                                {{ $trainerGameTimeSlot->game->description }}
                            </p>

                        @else

                            <p class="text-xs text-[var(--color-text-muted)]">
                                لا يوجد وصف لهذه اللعبة.
                            </p>

                        @endif

                    </div>

                    {{-- Time Slot --}}
                    <div
                        class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-background)] p-5">

                        <div class="mb-4 flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#D46417]/10 text-[#D46417]">

                                <i class="fa-regular fa-clock"></i>

                            </div>

                            <div>

                                <p class="text-[10px] text-[var(--color-text-muted)]">
                                    الفترة التدريبية
                                </p>

                                <h3 class="mt-1 text-sm font-bold">
                                    {{ $trainerGameTimeSlot->timeSlot?->name ?? 'غير محددة' }}
                                </h3>

                            </div>

                        </div>

                        @if ($trainerGameTimeSlot->timeSlot)

                            <div class="flex items-center gap-2">

                                <span
                                    class="rounded-lg bg-[#D46417]/10 px-3 py-2 text-sm font-bold text-[#D46417]">

                                    {{ \Carbon\Carbon::parse($trainerGameTimeSlot->timeSlot->start_time)->format('H:i') }}

                                </span>

                                <span class="text-xs text-[var(--color-text-muted)]">
                                    إلى
                                </span>

                                <span
                                    class="rounded-lg bg-[#D46417]/10 px-3 py-2 text-sm font-bold text-[#D46417]">

                                    {{ \Carbon\Carbon::parse($trainerGameTimeSlot->timeSlot->end_time)->format('H:i') }}

                                </span>

                            </div>

                        @else

                            <p class="text-xs text-red-400">
                                الفترة غير موجودة.
                            </p>

                        @endif

                    </div>

                </div>

                {{-- Time Slot Extra Information --}}
                @if ($trainerGameTimeSlot->timeSlot)

                    <div class="mt-6 rounded-2xl border border-[var(--color-border)] p-5">

                        <div class="mb-4 flex items-center gap-2">

                            <i class="fa-solid fa-calendar-days text-[#D46417]"></i>

                            <h3 class="text-sm font-bold">
                                معلومات الفترة
                            </h3>

                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">

                            {{-- Gender --}}
                            <div>

                                <span class="block text-xs text-[var(--color-text-muted)]">
                                    نوع الفترة
                                </span>

                                <strong class="mt-1 block text-sm">

                                    @switch($trainerGameTimeSlot->timeSlot->gender_type)

                                        @case('women_only')
                                            نساء فقط
                                            @break

                                        @case('mixed')
                                            مختلط
                                            @break

                                        @default
                                            {{ $trainerGameTimeSlot->timeSlot->gender_type }}

                                    @endswitch

                                </strong>

                            </div>

                            {{-- Days --}}
                            <div class="sm:col-span-2">

                                <span class="block text-xs text-[var(--color-text-muted)]">
                                    أيام الفترة
                                </span>

                                <div class="mt-2 flex flex-wrap gap-2">

                                    @forelse ((array) $trainerGameTimeSlot->timeSlot->days as $day)

                                        <span
                                            class="rounded-lg bg-[#D46417]/10 px-2.5 py-1.5 text-xs font-bold text-[#D46417]">

                                            {{ match ($day) {
                                                'saturday' => 'السبت',
                                                'sunday' => 'الأحد',
                                                'monday' => 'الاثنين',
                                                'tuesday' => 'الثلاثاء',
                                                'wednesday' => 'الأربعاء',
                                                'thursday' => 'الخميس',
                                                'friday' => 'الجمعة',
                                                default => $day,
                                            } }}

                                        </span>

                                    @empty

                                        <span class="text-xs text-[var(--color-text-muted)]">
                                            لا توجد أيام محددة.
                                        </span>

                                    @endforelse

                                </div>

                            </div>

                        </div>

                    </div>

                @endif

                {{-- Metadata --}}
                <div
                    class="mt-6 grid gap-4 border-t border-[var(--color-border)] pt-6 text-xs text-[var(--color-text-muted)] sm:grid-cols-2">

                    <div>

                        <span class="mb-1 block">
                            تاريخ إنشاء التعيين
                        </span>

                        <strong class="text-[var(--color-text)]">

                            {{ $trainerGameTimeSlot->created_at?->format('Y-m-d H:i') ?? '-' }}

                        </strong>

                    </div>

                    <div>

                        <span class="mb-1 block">
                            آخر تحديث
                        </span>

                        <strong class="text-[var(--color-text)]">

                            {{ $trainerGameTimeSlot->updated_at?->format('Y-m-d H:i') ?? '-' }}

                        </strong>

                    </div>

                </div>

            </div>

        </article>

        {{-- Delete --}}
        <div
            class="mt-6 flex flex-col gap-3 rounded-2xl border border-red-500/20 bg-red-500/5 p-5 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h3 class="text-sm font-bold text-red-400">
                    حذف التعيين
                </h3>

                <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                    سيؤدي حذف هذا التعيين إلى إزالة ارتباط المدرب بهذه اللعبة في هذه الفترة فقط.
                </p>

            </div>

            <form method="POST"
                action="{{ route('trainer-game-time-slots.destroy', $trainerGameTimeSlot) }}"
                onsubmit="return confirm('هل أنت متأكد من حذف تعيين هذا المدرب لهذه اللعبة؟');">

                @csrf
                @method('DELETE')

                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-red-500/30 px-5 py-3 text-sm font-bold text-red-400 transition hover:bg-red-500/10">

                    <i class="fa-solid fa-trash"></i>

                    حذف التعيين

                </button>

            </form>

        </div>

    </div>
@endsection
