@extends('layout.app')

@section('title', 'تعديل اللعبة')
@section('page-title', 'تعديل اللعبة')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('games.show', $game) }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"
                title="العودة"><i class="fa-solid fa-arrow-right"></i></a>
            <div>
                <h2 class="text-xl font-extrabold">تعديل {{ $game->name }}</h2>
                <p class="text-sm text-[var(--color-text-muted)]">حدّث بيانات اللعبة ثم احفظ التغييرات.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('games.update', $game) }}"
            class="space-y-5 rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 sm:p-7">
            @csrf
            @method('PUT')
            @include('game.partials.form-errors')
            <div>
                <label for="name" class="mb-2 block text-sm font-bold">اسم اللعبة</label>
                <input id="name" name="name" type="text" value="{{ old('name', $game->name) }}" required
                    autofocus
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-text)] outline-none transition focus:border-[#D46417]">
                @error('name')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="description" class="mb-2 block text-sm font-bold">وصف اللعبة</label>
                <textarea id="description" name="description" rows="6" required
                    class="w-full resize-y rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm leading-7 text-[var(--color-text)] outline-none transition focus:border-[#D46417]">{{ old('description', $game->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)] pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('games.show', $game) }}"
                    class="rounded-xl border border-[var(--color-border)] px-6 py-3 text-center text-sm font-bold text-[var(--color-text-muted)] transition hover:border-[#D46417]">إلغاء</a>
                <button type="submit"
                    class="rounded-xl bg-[#D46417] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#b95714]"><i
                        class="fa-solid fa-floppy-disk me-2"></i>حفظ التغييرات</button>
            </div>
        </form>
    </div>
@endsection
