@extends('layout.app')

@section('title', 'الإيصالات')
@section('page-title', 'الإيصالات')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-extrabold">إدارة الإيصالات</h2>
                <p class="mt-1 text-sm text-[var(--color-text-muted)]">عرض الإيصالات والبحث فيها وتصفيتها</p>
            </div>

            @can('reception.create')
                <a href="{{ route('receipts.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#D46417] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#b95412]">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    إضافة إيصال
                </a>
            @endcan
        </div>

        <form method="GET" action="{{ route('receipts.index') }}"
            class="grid grid-cols-1 gap-4 rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-4 sm:grid-cols-2 xl:grid-cols-4">
            <label class="space-y-2">
                <span class="text-sm font-semibold">اللعبة</span>
                <select name="filterByGame"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-2.5 text-sm outline-none focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
                    <option value="all">كل الألعاب</option>
                    @foreach ($games as $game)
                        <option value="{{ $game->id }}" @selected((string) request('filterByGame', 'all') === (string) $game->id)>
                            {{ $game->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="space-y-2">
                <span class="text-sm font-semibold">اللاعب</span>
                <select name="filterByPlayer"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-2.5 text-sm outline-none focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
                    <option value="all">كل اللاعبين</option>
                    @foreach ($players as $player)
                        <option value="{{ $player->id }}" @selected((string) request('filterByPlayer', 'all') === (string) $player->id)>
                            {{ $player->user?->fullname ?? 'لاعب بدون اسم' }} · #{{ $player->unique_number }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="space-y-2">
                <span class="text-sm font-semibold">الموظف المستلم</span>
                <input type="search" name="searchStaff" value="{{ request('searchStaff') }}" placeholder="ابحث باسم الموظف"
                    class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-2.5 text-sm outline-none placeholder:text-[var(--color-text-muted)] focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
            </label>

            <div class="flex items-end gap-2">
                <button type="submit"
                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-[#D46417] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#b95412]">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    بحث وتصفية
                </button>
                @if (request()->hasAny(['filterByGame', 'filterByPlayer', 'searchStaff']))
                    <a href="{{ route('receipts.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-semibold transition hover:bg-[var(--color-background)]"
                        aria-label="مسح الفلاتر" title="مسح الفلاتر">
                        <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
        </form>

        <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]">
            <div class="flex items-center justify-between border-b border-[var(--color-border)] px-4 py-3 sm:px-6">
                <h3 class="font-bold">سجل الإيصالات</h3>
                <span class="text-sm text-[var(--color-text-muted)]">{{ $receipts->count() }} إيصال</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-right">
                    <thead class="border-b border-[var(--color-border)] bg-[var(--color-background)]">
                        <tr>
                            <th scope="col" class="px-5 py-4 text-xs font-bold text-[var(--color-text-muted)]">رقم الإيصال
                            </th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold text-[var(--color-text-muted)]">اللاعب</th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold text-[var(--color-text-muted)]">اللعبة</th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold text-[var(--color-text-muted)]">الموظف
                                المستلم</th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold text-[var(--color-text-muted)]">المبلغ</th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold text-[var(--color-text-muted)]">تاريخ الدفع
                            </th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold text-[var(--color-text-muted)]">الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--color-border)]">
                        @forelse ($receipts as $receipt)
                            <tr class="transition hover:bg-[var(--color-surface-hover)]">
                                <td class="px-5 py-4 font-mono text-xs" dir="ltr">{{ $receipt->receipt_number }}</td>
                                <td class="px-5 py-4">
                                    <div class="font-semibold">{{ $receipt->player?->user?->fullname ?? 'غير محدد' }}</div>
                                    <div class="mt-1 text-xs text-[var(--color-text-muted)]">
                                        #{{ $receipt->player?->unique_number ?? '—' }}</div>
                                </td>
                                <td class="px-5 py-4 text-sm">{{ $receipt->game?->name ?? 'غير محددة' }}</td>
                                <td class="px-5 py-4 text-sm">{{ $receipt->receivedBy?->user?->fullname ?? 'غير محدد' }}</td>
                                <td class="px-5 py-4 text-sm font-bold">{{ number_format((float) $receipt->amount, 2) }}</td>
                                <td class="px-5 py-4 text-sm">{{ $receipt->payment_date?->format('Y-m-d') ?? '—' }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        @can('reception.view')
                                            <a href="{{ route('receipts.show', $receipt) }}"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] transition hover:border-[#D46417] hover:text-[#D46417]"
                                                aria-label="عرض الإيصال" title="عرض الإيصال">
                                                <i class="fa-solid fa-eye text-xs" aria-hidden="true"></i>
                                            </a>
                                        @endcan
                                        @can('reception.edit')
                                            <a href="{{ route('receipts.edit', $receipt) }}"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] transition hover:border-[#D46417] hover:text-[#D46417]"
                                                aria-label="تعديل الإيصال" title="تعديل الإيصال">
                                                <i class="fa-solid fa-pen text-xs" aria-hidden="true"></i>
                                            </a>
                                        @endcan
                                        @can('reception.delete')
                                            <form method="POST" action="{{ route('receipts.destroy', $receipt) }}"
                                                onsubmit="return confirm('هل تريد حذف هذا الإيصال؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-red-500/20 text-red-500 transition hover:bg-red-500/10"
                                                    aria-label="حذف الإيصال" title="حذف الإيصال">
                                                    <i class="fa-solid fa-trash text-xs" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-[#D46417]/10 text-xl text-[#D46417]">
                                        <i class="fa-solid fa-receipt" aria-hidden="true"></i>
                                    </div>
                                    <h3 class="mt-4 font-bold">لا توجد إيصالات مطابقة</h3>
                                    <p class="mt-1 text-sm text-[var(--color-text-muted)]">جرّب تغيير كلمات البحث أو الفلاتر.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection