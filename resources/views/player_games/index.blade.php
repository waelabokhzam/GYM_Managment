@extends('layout.app')

@section('title','ربط اللاعبين بالألعاب')
@section('page-title','ربط اللاعبين بالألعاب')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-xl font-extrabold">
                إدارة ربط اللاعبين بالألعاب
            </h2>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                إدارة الألعاب التي ينتمي إليها كل لاعب.
            </p>
        </div>

        @can('players.edit')
        <a href="{{ route('player-games.create') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95412]">
            <i class="fa-solid fa-plus"></i>
            ربط جديد
        </a>
        @endcan

    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px] text-right">

                <thead class="border-b border-[var(--color-border)] bg-[var(--color-background)]">
                    <tr>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            اللاعب
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الرقم الخاص
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            اللعبة
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الإجراءات
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse($playerGames as $item)

                    <tr class="transition hover:bg-[var(--color-surface-hover)]">

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#D46417] font-bold text-white">
                                    {{ mb_substr($item->player->user->fullname,0,1) }}
                                </div>

                                <div>

                                    <div class="font-bold">
                                        {{ $item->player->user->fullname }}
                                    </div>

                                    <div class="text-xs text-[var(--color-text-muted)]">
                                        {{ $item->player->user->username }}
                                    </div>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-4 text-sm font-bold">
                            {{ $item->player->unique_number }}
                        </td>

                        <td class="px-6 py-4">

                            <span class="rounded-lg bg-[#D46417]/10 px-3 py-1.5 text-xs font-bold text-[#D46417]">
                                {{ $item->game->name }}
                            </span>

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex gap-2">

                                @can('players.view')
                                <a href="{{ route('player-games.show',$item) }}"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>
                                @endcan

                                @can('players.edit')
                                <a href="{{ route('player-games.edit',$item) }}"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                @endcan

                                @can('players.edit')
                                <form method="POST" action="{{ route('player-games.destroy',$item) }}"
                                    onsubmit="return confirm('هل تريد حذف هذا الربط؟');">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-red-500/20 text-red-400 transition hover:bg-red-500/10">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>

                                </form>
                                @endcan

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">

                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#D46417]/10 text-2xl text-[#D46417]">
                                <i class="fa-solid fa-dumbbell"></i>
                            </div>

                            <h3 class="mt-4 font-bold">
                                لا توجد روابط
                            </h3>

                            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                                لم يتم ربط أي لاعب بأي لعبة حتى الآن.
                            </p>

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($playerGames->hasPages())
        <div class="border-t border-[var(--color-border)] p-4">
            {{ $playerGames->links() }}
        </div>
        @endif

    </div>

</div>

@endsection