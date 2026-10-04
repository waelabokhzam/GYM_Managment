@extends('layout.app')

@section('title', 'الفترات الزمنية')
@section('page-title', 'الفترات الزمنية')

@section('content')

    @php
        $dayNames = [
            'saturday' => 'السبت',
            'sunday' => 'الأحد',
            'monday' => 'الإثنين',
            'tuesday' => 'الثلاثاء',
            'wednesday' => 'الأربعاء',
            'thursday' => 'الخميس',
            'friday' => 'الجمعة',
        ];
    @endphp

    <div class="mx-auto max-w-7xl space-y-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm text-[var(--color-text-muted)]">
                    تنظيم أوقات استخدام النادي حسب نوع الفترة والأيام.
                </p>
            </div>

            @can('create', App\Models\TimeSlot::class)

                <a
                    href="{{ route('timeslots.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95714]"
                >

                    <i class="fa-solid fa-plus"></i>
                    إضافة فترة

                </a>

            @endcan

        </div>

        @if ($timeslots->isEmpty())

            <div
                class="rounded-2xl border border-dashed border-[var(--color-border)] bg-[var(--color-surface)] px-6 py-16 text-center"
            >

                <i class="fa-regular fa-clock mb-4 text-3xl text-[#D46417]"></i>

                <h2 class="text-lg font-bold">
                    لا توجد فترات زمنية
                </h2>

                <p class="mt-2 text-sm text-[var(--color-text-muted)]">
                    أضف فترة جديدة لتنظيم أوقات النادي.
                </p>

            </div>

        @else

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">

                @foreach ($timeslots as $timeslot)

                    @php
                        $isWomenOnly = $timeslot->gender_type === 'women_only';
                    @endphp

                    <article
                        class="flex flex-col rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 transition hover:border-[#D46417]/60"
                    >

                        {{-- Header --}}
                        <div class="flex items-start justify-between gap-4">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#D46417]/15 text-[#D46417]"
                                >
                                    <i class="fa-regular fa-clock"></i>
                                </div>

                                <div class="min-w-0">

                                    <h2 class="truncate text-lg font-bold">
                                        {{ $timeslot->name }}
                                    </h2>

                                    <span
                                        class="text-xs text-[var(--color-text-muted)]"
                                        dir="ltr"
                                    >
                                        {{ substr($timeslot->start_time, 0, 5) }}
                                        -
                                        {{ substr($timeslot->end_time, 0, 5) }}
                                    </span>

                                </div>

                            </div>

                            <span
                                class="shrink-0 rounded-full px-3 py-1 text-xs font-bold {{ $isWomenOnly ? 'bg-pink-500/10 text-pink-300' : 'bg-sky-500/10 text-sky-300' }}"
                            >
                                {{ $isWomenOnly ? 'نساء فقط' : 'مختلطة' }}
                            </span>

                        </div>

                        {{-- Days --}}
                        <div class="mt-5">

                            <span class="mb-2 block text-xs font-bold text-[var(--color-text-muted)]">
                                الأيام
                            </span>

                            <div class="flex flex-wrap gap-2">

                                @foreach ($timeslot->days ?? [] as $day)

                                    <span
                                        class="rounded-lg bg-[#D46417]/10 px-2.5 py-1.5 text-xs font-bold text-[#D46417]"
                                    >
                                        {{ $dayNames[$day] ?? $day }}
                                    </span>

                                @endforeach

                            </div>

                        </div>

                        {{-- Footer --}}
                        <div
                            class="mt-5 flex items-center justify-between border-t border-[var(--color-border)] pt-4"
                        >

                            <a
                                href="{{ route('timeslots.show', $timeslot->id) }}"
                                class="text-sm font-bold text-[#D46417] hover:underline"
                            >
                                عرض التفاصيل

                                <i class="fa-solid fa-arrow-left ms-1 text-xs"></i>
                            </a>

                            @can('update', $timeslot)

                                <a
                                    href="{{ route('timeslots.edit', $timeslot->id) }}"
                                    class="text-[var(--color-text-muted)] transition hover:text-[#D46417]"
                                    title="تعديل"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                            @endcan

                        </div>

                    </article>

                @endforeach

            </div>

            @if ($timeslots->hasPages())

                <div class="pt-2">
                    {{ $timeslots->links() }}
                </div>

            @endif

        @endif

    </div>

@endsection