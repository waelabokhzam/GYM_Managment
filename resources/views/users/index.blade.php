@extends('layout.app')

@section('title', 'المستخدمون')
@section('page-title', 'المستخدمون')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-xl font-extrabold">
                إدارة المستخدمين
            </h2>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                إدارة حسابات المستخدمين وصلاحياتهم وبياناتهم
            </p>
        </div>

        @can('users.create')

            <a
                href="{{ route('users.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95412]"
            >
                <i class="fa-solid fa-plus"></i>
                إضافة مستخدم
            </a>

        @endcan

    </div>


    {{-- Search --}}
    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-4">

        <form
            method="GET"
            action="{{ route('users.index') }}"
            class="flex flex-col gap-3 sm:flex-row"
        >

            <div class="relative flex-1">

                <i class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-[var(--color-text-muted)]"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="البحث بالاسم أو اسم المستخدم أو الهاتف..."
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] py-3 pl-4 pr-11 text-sm text-[var(--color-text)] outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10"
                >

            </div>

            <button
                type="submit"
                class="rounded-xl bg-[#D46417] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#b95412]"
            >
                بحث
            </button>

        </form>

    </div>


    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1100px] text-right">

                <thead class="border-b border-[var(--color-border)] bg-[var(--color-background)]">

                    <tr>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الاسم
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            اسم المستخدم
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الرقم الخاص
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            المهنة
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الجنس
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الصلاحية
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الإجراءات
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse ($users as $user)

                        @php
                            $role = $user->roles->first()?->name;
                        @endphp

                        <tr class="transition hover:bg-[var(--color-surface-hover)]">

                            {{-- Fullname --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#D46417] font-bold text-white">

                                        {{ mb_substr($user->fullname, 0, 1) }}

                                    </div>

                                    <div>

                                        <div class="font-bold">
                                            {{ $user->fullname }}
                                        </div>

                                        <div class="mt-1 text-xs text-[var(--color-text-muted)]">
                                            #{{ $user->id }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Username --}}
                            <td class="px-6 py-4">

                                <span class="rounded-lg bg-[var(--color-background)] px-3 py-1.5 text-xs font-bold">
                                    {{ $user->username }}
                                </span>

                            </td>


                            {{-- Unique Number --}}
                            <td class="px-6 py-4 text-sm">

                                @if ($role === 'player' && $user->player)

                                    {{ $user->player->unique_number }}

                                @else

                                    <span class="text-[var(--color-text-muted)]">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Occupation --}}
                            <td class="px-6 py-4 text-sm">

                                @if ($role === 'player' && $user->player)

                                    {{ $user->player->occupation ?: '—' }}

                                @else

                                    <span class="text-[var(--color-text-muted)]">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Gender --}}
                            <td class="px-6 py-4">

                                @if ($role === 'player' && $user->player)

                                    @if ($user->player->gender === 'male')

                                        <span class="rounded-lg bg-blue-500/10 px-3 py-1.5 text-xs font-bold text-blue-500">
                                            ذكر
                                        </span>

                                    @else

                                        <span class="rounded-lg bg-pink-500/10 px-3 py-1.5 text-xs font-bold text-pink-500">
                                            أنثى
                                        </span>

                                    @endif

                                @else

                                    <span class="text-[var(--color-text-muted)]">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Role --}}
                            <td class="px-6 py-4">

                                @switch($role)

                                    @case('admin')

                                        <span class="rounded-lg bg-red-500/10 px-3 py-1.5 text-xs font-bold text-red-500">
                                            أدمن
                                        </span>

                                        @break

                                    @case('reception')

                                        <span class="rounded-lg bg-blue-500/10 px-3 py-1.5 text-xs font-bold text-blue-500">
                                            موظف استقبال
                                        </span>

                                        @break

                                    @case('trainer')

                                        <span class="rounded-lg bg-[#D46417]/10 px-3 py-1.5 text-xs font-bold text-[#D46417]">
                                            مدرب
                                        </span>

                                        @break

                                    @case('player')

                                        <span class="rounded-lg bg-green-500/10 px-3 py-1.5 text-xs font-bold text-green-500">
                                            لاعب
                                        </span>

                                        @break

                                    @default

                                        <span class="text-[var(--color-text-muted)]">
                                            —
                                        </span>

                                @endswitch

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-2">

                                    @can('users.view')

                                        <a
                                            href="{{ route('users.show', $user) }}"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"
                                            title="عرض"
                                        >
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>

                                    @endcan


                                    @can('users.edit')

                                        <a
                                            href="{{ route('users.edit', $user) }}"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"
                                            title="تعديل"
                                        >
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                    @endcan


                                    @can('users.delete')

                                        @if (auth()->id() !== $user->id)

                                            <form
                                                method="POST"
                                                action="{{ route('users.destroy', $user) }}"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-red-500/20 text-red-400 transition hover:bg-red-500/10"
                                                    title="حذف"
                                                >
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>

                                            </form>

                                        @endif

                                    @endcan

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#D46417]/10 text-2xl text-[#D46417]">

                                    <i class="fa-solid fa-users"></i>

                                </div>

                                <h3 class="mt-4 font-bold">
                                    لا يوجد مستخدمون
                                </h3>

                                <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                                    لم يتم العثور على أي مستخدمين.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if ($users->hasPages())

            <div class="border-t border-[var(--color-border)] p-4">
                {{ $users->links() }}
            </div>

        @endif

    </div>

</div>

@endsection