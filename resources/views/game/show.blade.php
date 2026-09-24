@extends('layout.app')

@section('title', $game->name)
@section('page-title', 'تفاصيل اللعبة')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center justify-between gap-4">
            <a href="{{ route('games.index') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-[var(--color-text-muted)] transition hover:text-[#D46417]"><i
                    class="fa-solid fa-arrow-right"></i> العودة للألعاب</a>
            @can('update', $game)
                <a href="{{ route('games.edit', $game) }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--color-border)] px-4 py-2.5 text-sm font-bold text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"><i
                        class="fa-solid fa-pen-to-square"></i> تعديل</a>
            @endcan
        </div>

        <article class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 sm:p-10">
            <div class="flex flex-col gap-5 border-b border-[var(--color-border)] pb-7 sm:flex-row sm:items-center">
                <div
                    class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[#D46417]/15 text-2xl text-[#D46417]">
                    <i class="fa-solid fa-dumbbell"></i></div>
                <div>
                    <span class="text-xs text-[var(--color-text-muted)]">لعبة رقم #{{ $game->id }}</span>
                    <h2 class="mt-1 text-2xl font-extrabold">{{ $game->name }}</h2>
                </div>
            </div>
            <div class="pt-7">
                <h3 class="mb-3 text-sm font-bold text-[#D46417]">الوصف</h3>
                <p class="whitespace-pre-line text-sm leading-8 text-[var(--color-text-muted)]">{{ $game->description }}</p>
            </div>
            <div
                class="mt-8 grid gap-4 border-t border-[var(--color-border)] pt-6 text-xs text-[var(--color-text-muted)] sm:grid-cols-2">
                <div><span class="block mb-1">تاريخ الإضافة</span><strong
                        class="text-[var(--color-text)]">{{ $game->created_at?->format('Y-m-d H:i') }}</strong></div>
                <div><span class="block mb-1">آخر تحديث</span><strong
                        class="text-[var(--color-text)]">{{ $game->updated_at?->format('Y-m-d H:i') }}</strong></div>
            </div>
        </article>

        @can('delete', $game)
            <form method="POST" action="{{ route('games.destroy', $game) }}" class="mt-6 flex justify-end"
                onsubmit="return confirm('هل أنت متأكد من حذف هذه اللعبة؟');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center gap-2 text-sm font-bold text-red-400 transition hover:text-red-300"><i
                        class="fa-solid fa-trash"></i> حذف اللعبة</button>
            </form>
        @endcan
    </div>
@endsection
