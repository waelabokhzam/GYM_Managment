@extends('layout.app')

@section('title', 'اللاعبين')

@section('page-title', 'اللاعبين')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-extrabold tracking-tight sm:text-3xl">
                اللاعبين
            </h1>

            <p class="mt-2 text-sm text-[var(--color-text-muted)]">
                إدارة ومتابعة جميع اللاعبين المسجلين في النادي.
            </p>
        </div>

        @can('create', App\Models\Player::class)
            <a
                href="{{ route('players.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#b95310] focus:outline-none focus:ring-2 focus:ring-[#D46417]/50"
            >
                <i class="fa-solid fa-user-plus"></i>
                إضافة لاعب
            </a>
        @endcan

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-4 text-sm text-green-600 dark:text-green-400">

            <div class="flex items-center gap-3">

                <i class="fa-solid fa-circle-check text-lg"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        </div>

    @endif


    {{-- Generated Account Information --}}
    @if(session('generated_username') || session('unique_number'))

        <div class="rounded-2xl border border-[#D46417]/30 bg-[#D46417]/10 p-5">

            <div class="mb-4 flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#D46417]/15 text-[#D46417]">
                    <i class="fa-solid fa-circle-info"></i>
                </div>

                <div>
                    <h2 class="font-bold">
                        تم إنشاء حساب اللاعب
                    </h2>

                    <p class="text-sm text-[var(--color-text-muted)]">
                        احتفظ ببيانات الدخول الخاصة باللاعب.
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                @if(session('generated_username'))

                    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-4">

                        <p class="text-xs font-semibold text-[var(--color-text-muted)]">
                            اسم المستخدم
                        </p>

                        <p class="mt-1 text-lg font-extrabold text-[#D46417]">
                            {{ session('generated_username') }}
                        </p>

                    </div>

                @endif


                @if(session('unique_number'))

                    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-4">

                        <p class="text-xs font-semibold text-[var(--color-text-muted)]">
                            الرقم الخاص باللاعب
                        </p>

                        <p class="mt-1 text-lg font-extrabold">
                            {{ session('unique_number') }}
                        </p>

                    </div>

                @endif

            </div>

        </div>

    @endif


    {{-- Players Table --}}
    <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        {{-- Table Header --}}
        <div class="border-b border-[var(--color-border)] px-5 py-4">

            <div class="flex items-center justify-between">

                <div>
                    <h2 class="font-extrabold">
                        قائمة اللاعبين
                    </h2>

                    <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                        إجمالي النتائج الحالية:
                        {{ $players->total() }}
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#D46417]/15 text-[#D46417]">
                    <i class="fa-solid fa-users"></i>
                </div>

            </div>

        </div>


        {{-- Desktop Table --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="w-full text-right text-sm">

                <thead class="border-b border-[var(--color-border)] bg-black/[0.03] dark:bg-white/[0.03]">

                    <tr>

                        <th class="whitespace-nowrap px-5 py-4 font-bold">
                            #
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 font-bold">
                            اللاعب
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 font-bold">
                            رقم اللاعب
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 font-bold">
                            اسم المستخدم
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 font-bold">
                            الهاتف
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 font-bold">
                            الجنس
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 font-bold">
                            الطول
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 font-bold">
                            الوزن
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 text-center font-bold">
                            الإجراءات
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse($players as $player)

                        <tr class="transition hover:bg-[#D46417]/5">

                            {{-- ID --}}
                            <td class="px-5 py-4 text-[var(--color-text-muted)]">
                                {{ $player->id }}
                            </td>


                            {{-- Player --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#D46417]/15 font-bold text-[#D46417]">

                                        {{ mb_substr($player->user->fullname ?? '-', 0, 1) }}

                                    </div>

                                    <div>

                                        <p class="font-bold">
                                            {{ $player->user->fullname ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                                            {{ $player->user->phone ?? '-' }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- Unique Number --}}
                            <td class="px-5 py-4">

                                <span class="rounded-lg bg-[#D46417]/10 px-3 py-1.5 font-bold text-[#D46417]">
                                    {{ $player->unique_number }}
                                </span>

                            </td>


                            {{-- Username --}}
                            <td class="px-5 py-4 font-medium">
                                {{ $player->user->username ?? '-' }}
                            </td>


                            {{-- Phone --}}
                            <td class="px-5 py-4">
                                {{ $player->user->phone ?? '-' }}
                            </td>


                            {{-- Gender --}}
                            <td class="px-5 py-4">

                                @if($player->gender === 'male')

                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-500/10 px-3 py-1.5 text-xs font-bold text-blue-600 dark:text-blue-400">
                                        <i class="fa-solid fa-mars"></i>
                                        ذكر
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-pink-500/10 px-3 py-1.5 text-xs font-bold text-pink-600 dark:text-pink-400">
                                        <i class="fa-solid fa-venus"></i>
                                        أنثى
                                    </span>

                                @endif

                            </td>


                            {{-- Height --}}
                            <td class="px-5 py-4">
                                {{ $player->height ? $player->height . ' سم' : '-' }}
                            </td>


                            {{-- Weight --}}
                            <td class="px-5 py-4">
                                {{ $player->weight ? $player->weight . ' كغ' : '-' }}
                            </td>


                            {{-- Actions --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- Show --}}
                                    @can('view', $player)

                                        <a
                                            href="{{ route('players.show', $player) }}"
                                            title="عرض"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417]/50 hover:bg-[#D46417]/10 hover:text-[#D46417]"
                                        >
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                    @endcan


                                    {{-- Edit --}}
                                    @can('update', $player)

                                        <a
                                            href="{{ route('players.edit', $player) }}"
                                            title="تعديل"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417]/50 hover:bg-[#D46417]/10 hover:text-[#D46417]"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                    @endcan


                                    {{-- Delete --}}
                                    @can('delete', $player)

                                        <form
                                            action="{{ route('players.destroy', $player) }}"
                                            method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا اللاعب؟');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="حذف"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-red-500/20 text-red-500 transition hover:bg-red-500/10"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                        </form>

                                    @endcan

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" class="px-5 py-16 text-center">

                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#D46417]/10 text-2xl text-[#D46417]">
                                    <i class="fa-solid fa-user-slash"></i>
                                </div>

                                <h3 class="mt-4 font-bold">
                                    لا يوجد لاعبين
                                </h3>

                                <p class="mt-2 text-sm text-[var(--color-text-muted)]">
                                    لم يتم تسجيل أي لاعب حتى الآن.
                                </p>

                                @can('create', App\Models\Player::class)

                                    <a
                                        href="{{ route('players.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#b95310]"
                                    >
                                        <i class="fa-solid fa-user-plus"></i>
                                        إضافة أول لاعب
                                    </a>

                                @endcan

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Mobile Cards --}}
        <div class="divide-y divide-[var(--color-border)] md:hidden">

            @forelse($players as $player)

                <div class="p-5">

                    <div class="flex items-start justify-between gap-3">

                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#D46417]/15 font-bold text-[#D46417]">
                                {{ mb_substr($player->user->fullname ?? '-', 0, 1) }}
                            </div>

                            <div>

                                <h3 class="font-bold">
                                    {{ $player->user->fullname ?? '-' }}
                                </h3>

                                <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                                    {{ $player->unique_number }}
                                </p>

                            </div>

                        </div>

                        @if($player->gender === 'male')

                            <span class="rounded-lg bg-blue-500/10 px-2 py-1 text-xs font-bold text-blue-600">
                                ذكر
                            </span>

                        @else

                            <span class="rounded-lg bg-pink-500/10 px-2 py-1 text-xs font-bold text-pink-600">
                                أنثى
                            </span>

                        @endif

                    </div>


                    <div class="mt-4 grid grid-cols-2 gap-3 text-sm">

                        <div class="rounded-xl border border-[var(--color-border)] p-3">

                            <p class="text-xs text-[var(--color-text-muted)]">
                                اسم المستخدم
                            </p>

                            <p class="mt-1 font-semibold">
                                {{ $player->user->username ?? '-' }}
                            </p>

                        </div>

                        <div class="rounded-xl border border-[var(--color-border)] p-3">

                            <p class="text-xs text-[var(--color-text-muted)]">
                                الهاتف
                            </p>

                            <p class="mt-1 font-semibold">
                                {{ $player->user->phone ?? '-' }}
                            </p>

                        </div>

                    </div>


                    <div class="mt-4 flex items-center gap-2">

                        @can('view', $player)

                            <a
                                href="{{ route('players.show', $player) }}"
                                class="flex flex-1 items-center justify-center gap-2 rounded-xl border border-[var(--color-border)] py-2.5 text-sm font-bold transition hover:border-[#D46417]/50 hover:text-[#D46417]"
                            >
                                <i class="fa-solid fa-eye"></i>
                                عرض
                            </a>

                        @endcan


                        @can('update', $player)

                            <a
                                href="{{ route('players.edit', $player) }}"
                                class="flex flex-1 items-center justify-center gap-2 rounded-xl border border-[var(--color-border)] py-2.5 text-sm font-bold transition hover:border-[#D46417]/50 hover:text-[#D46417]"
                            >
                                <i class="fa-solid fa-pen"></i>
                                تعديل
                            </a>

                        @endcan


                        @can('delete', $player)

                            <form
                                action="{{ route('players.destroy', $player) }}"
                                method="POST"
                                class="flex-1"
                                onsubmit="return confirm('هل أنت متأكد من حذف هذا اللاعب؟');"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-500/20 py-2.5 text-sm font-bold text-red-500 transition hover:bg-red-500/10"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                    حذف
                                </button>

                            </form>

                        @endcan

                    </div>

                </div>

            @empty

                <div class="px-5 py-16 text-center text-sm text-[var(--color-text-muted)]">
                    لا يوجد لاعبين حالياً.
                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if($players->hasPages())

            <div class="border-t border-[var(--color-border)] px-5 py-4">
                {{ $players->links() }}
            </div>

        @endif

    </div>

</div>

@endsection