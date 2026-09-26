@extends('layout.app')

@section('title', 'تفاصيل الربط')
@section('page-title', 'تفاصيل الربط')

@section('content')

    <div class="mx-auto max-w-4xl space-y-6">

        <div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

            <div class="flex items-center gap-4">

                <div
                    class="flex h-16 w-16 items-center justify-center rounded-full bg-[#D46417] text-xl font-bold text-white">

                    {{ mb_substr($trainerTimeSlot->trainer->user->fullname, 0, 1) }}

                </div>

                <div>

                    <h2 class="text-2xl font-extrabold">

                        {{ $trainerTimeSlot->trainer->user->fullname }}

                    </h2>

                    <p class="text-[var(--color-text-muted)]">

                        {{ $trainerTimeSlot->trainer->user->username }}

                    </p>

                </div>

            </div>

        </div>

        <div class="grid gap-5 md:grid-cols-3">

            <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

                <p class="text-xs text-[var(--color-text-muted)]">

                    بداية الفترة

                </p>

                <p class="mt-2 text-lg font-bold">

                    {{ \Carbon\Carbon::parse($trainerTimeSlot->timeSlot->start_time)->format('H:i') }}

                </p>

            </div>

            <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

                <p class="text-xs text-[var(--color-text-muted)]">

                    نهاية الفترة

                </p>

                <p class="mt-2 text-lg font-bold">

                    {{ \Carbon\Carbon::parse($trainerTimeSlot->timeSlot->end_time)->format('H:i') }}

                </p>

            </div>

            <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

                <p class="text-xs text-[var(--color-text-muted)]">

                    نوع الفترة

                </p>

                <p class="mt-2 text-lg font-bold">

                    {{ $trainerTimeSlot->timeSlot->gender_type == 'mixed' ? 'مختلط' : 'سيدات' }}

                </p>

            </div>

        </div>

        <div class="flex justify-end gap-3">

            <a href="{{ route('trainer-time-slots.index') }}"
                class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">

                رجوع

            </a>

            @can('training_periods.edit')
                <a href="{{ route('trainer-time-slots.edit', $trainerTimeSlot) }}"
                    class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white">

                    تعديل

                </a>
            @endcan

        </div>

    </div>

@endsection
