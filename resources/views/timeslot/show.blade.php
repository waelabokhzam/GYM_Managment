@extends('layout.app')

@section('title', 'تفاصيل الفترة الزمنية')
@section('page-title', 'تفاصيل الفترة الزمنية')

@section('content')
    @php
        $isWomenOnly = $timeslot->gender_type === 'women_only';
    @endphp

    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center justify-between gap-4">
            <a href="{{ route('timeslots.index') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-[var(--color-text-muted)] transition hover:text-[#D46417]"><i
                    class="fa-solid fa-arrow-right"></i> العودة للفترات</a>
            @can('update', $timeslot)
                <a href="{{ route('timeslots.edit', $timeslot) }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--color-border)] px-4 py-2.5 text-sm font-bold text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"><i
                        class="fa-solid fa-pen-to-square"></i> تعديل</a>
            @endcan
        </div>

        <article class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 sm:p-10">
            <div class="flex flex-col gap-5 border-b border-[var(--color-border)] pb-7 sm:flex-row sm:items-center">
                <div
                    class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[#D46417]/15 text-2xl text-[#D46417]">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div>
                    <span class="text-xs text-[var(--color-text-muted)]">فترة زمنية رقم #{{ $timeslot->id }}</span>
                    <h2 class="mt-1 text-2xl font-extrabold" dir="ltr">{{ substr($timeslot->start_time, 0, 5) }} -
                        {{ substr($timeslot->end_time, 0, 5) }}
                    </h2>
                </div>
            </div>

            <div class="grid gap-4 pt-7 sm:grid-cols-2">
                <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-4">
                    <span class="mb-2 block text-xs text-[var(--color-text-muted)]">نوع الفترة</span>
                    <strong
                        class="inline-flex items-center gap-2 text-sm {{ $isWomenOnly ? 'text-pink-300' : 'text-sky-300' }}"><i
                            class="fa-solid {{ $isWomenOnly ? 'fa-person-dress' : 'fa-people-group' }}"></i>{{ $isWomenOnly ? 'نساء فقط' : 'مختلطة' }}</strong>
                </div>
                <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-4">
                    <span class="mb-2 block text-xs text-[var(--color-text-muted)]">الحالة</span>
                    <strong class="inline-flex items-center gap-2 text-sm text-emerald-400"><i
                            class="fa-solid fa-circle-check"></i>متاحة</strong>
                </div>
            </div>

            <div
                class="mt-8 grid gap-4 border-t border-[var(--color-border)] pt-6 text-xs text-[var(--color-text-muted)] sm:grid-cols-2">
                <div><span class="mb-1 block">تاريخ الإضافة</span><strong
                        class="text-[var(--color-text)]">{{ $timeslot->created_at?->format('Y-m-d H:i') }}</strong></div>
                <div><span class="mb-1 block">آخر تحديث</span><strong
                        class="text-[var(--color-text)]">{{ $timeslot->updated_at?->format('Y-m-d H:i') }}</strong></div>
            </div>
        </article>

        @can('delete', $timeslot)
            <form method="POST" action="{{ route('timeslots.destroy', ['timeslot' => $timeslot]) }}"
                class="mt-6 flex justify-end" onsubmit="return confirm('هل أنت متأكد من حذف هذه الفترة؟');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center gap-2 text-sm font-bold text-red-400 transition hover:text-red-300"><i
                        class="fa-solid fa-trash"></i> حذف الفترة</button>
            </form>
        @endcan
    </div>
@endsection