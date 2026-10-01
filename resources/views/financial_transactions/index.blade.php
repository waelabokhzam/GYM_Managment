@extends('layout.app')

@section('title','المعاملات المالية')
@section('page-title','المعاملات المالية')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h2 class="text-xl font-extrabold">
                المعاملات المالية
            </h2>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                إدارة المقبوضات والمدفوعات المالية في النادي.
            </p>

        </div>

        @can('financial_transactions.create')

        <a href="{{ route('financial-transactions.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95412]">

            <i class="fa-solid fa-plus"></i>

            حركة مالية جديدة

        </a>

        @endcan

    </div>


    {{-- Filters --}}
    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

        <form method="GET"
              action="{{ route('financial-transactions.index') }}">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">

                {{-- Search --}}
                <div class="xl:col-span-2">

                    <label class="mb-2 block text-sm font-bold">
                        البحث
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-[var(--color-text-muted)]"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="البحث في سبب الحركة..."
                            class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] py-3 pl-4 pr-11 text-sm outline-none transition focus:border-[#D46417]"
                        >

                    </div>

                </div>


                {{-- Type --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        نوع الحركة
                    </label>

                    <select
                        name="transaction_type"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none focus:border-[#D46417]"
                    >

                        <option value="">
                            الكل
                        </option>

                        <option value="income"
                            @selected(request('transaction_type') === 'income')>
                            قبض
                        </option>

                        <option value="expense"
                            @selected(request('transaction_type') === 'expense')>
                            صرف
                        </option>

                    </select>

                </div>


                {{-- Approved By --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        الموظف المعتمد
                    </label>

                    <select
                        name="approved_by"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none focus:border-[#D46417]"
                    >

                        <option value="">
                            جميع الموظفين
                        </option>

                        @foreach($employees as $employee)

                            <option
                                value="{{ $employee->id }}"
                                @selected((string) request('approved_by') === (string) $employee->id)
                            >
                                {{ $employee->fullname }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Date From --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        من تاريخ
                    </label>

                    <input
                        type="date"
                        name="date_from"
                        value="{{ request('date_from') }}"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none focus:border-[#D46417]"
                    >

                </div>


                {{-- Date To --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        إلى تاريخ
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        value="{{ request('date_to') }}"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none focus:border-[#D46417]"
                    >

                </div>

            </div>


            <div class="mt-4 flex flex-wrap gap-2">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#b95412]"
                >

                    <i class="fa-solid fa-filter"></i>

                    تطبيق الفلاتر

                </button>

                <a
                    href="{{ route('financial-transactions.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--color-border)] px-5 py-3 text-sm font-bold transition hover:border-[#D46417] hover:text-[#D46417]"
                >

                    <i class="fa-solid fa-rotate-left"></i>

                    إعادة تعيين

                </a>

            </div>

        </form>

    </div>


    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1000px] text-right">

                <thead class="border-b border-[var(--color-border)] bg-[var(--color-background)]">

                    <tr>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            نوع الحركة
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            المبلغ
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            سبب الحركة
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            المعتمد
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            التاريخ
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الإجراءات
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse($transactions as $transaction)

                        <tr class="transition hover:bg-[var(--color-surface-hover)]">

                            {{-- Type --}}
                            <td class="px-6 py-4">

                                @if($transaction->transaction_type === 'income')

                                    <span class="inline-flex items-center gap-2 rounded-lg bg-green-500/10 px-3 py-1.5 text-xs font-bold text-green-500">

                                        <i class="fa-solid fa-arrow-down"></i>

                                        قبض

                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-2 rounded-lg bg-red-500/10 px-3 py-1.5 text-xs font-bold text-red-500">

                                        <i class="fa-solid fa-arrow-up"></i>

                                        صرف

                                    </span>

                                @endif

                            </td>


                            {{-- Amount --}}
                            <td class="px-6 py-4">

                                <span class="font-extrabold">

                                    {{ number_format($transaction->amount, 2) }}

                                </span>

                            </td>


                            {{-- Description --}}
                            <td class="max-w-[300px] px-6 py-4">

                                <div class="truncate text-sm"
                                     title="{{ $transaction->description }}">

                                    {{ $transaction->description }}

                                </div>

                            </td>


                            {{-- Approver --}}
                            <td class="px-6 py-4">

                                @if($transaction->approver)

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#D46417] text-sm font-bold text-white">

                                            {{ mb_substr($transaction->approver->fullname, 0, 1) }}

                                        </div>

                                        <div>

                                            <div class="text-sm font-bold">

                                                {{ $transaction->approver->fullname }}

                                            </div>

                                            <div class="text-xs text-[var(--color-text-muted)]">

                                                {{ $transaction->approver->username }}

                                            </div>

                                        </div>

                                    </div>

                                @else

                                    <span class="text-sm text-[var(--color-text-muted)]">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Date --}}
                            <td class="px-6 py-4 text-sm">

                                {{ $transaction->created_at->format('Y-m-d H:i') }}

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    @can('view', $transaction)

                                        <a
                                            href="{{ route('financial-transactions.show', $transaction) }}"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] transition hover:border-[#D46417] hover:text-[#D46417]"
                                            title="عرض"
                                        >

                                            <i class="fa-solid fa-eye text-xs"></i>

                                        </a>

                                    @endcan


                                    @can('update', $transaction)

                                        <a
                                            href="{{ route('financial-transactions.edit', $transaction) }}"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] transition hover:border-[#D46417] hover:text-[#D46417]"
                                            title="تعديل"
                                        >

                                            <i class="fa-solid fa-pen text-xs"></i>

                                        </a>

                                    @endcan


                                    @can('delete', $transaction)

                                        <form
                                            method="POST"
                                            action="{{ route('financial-transactions.destroy', $transaction) }}"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذه الحركة المالية؟');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] text-red-500 transition hover:border-red-500 hover:bg-red-500/10"
                                                title="حذف"
                                            >

                                                <i class="fa-solid fa-trash text-xs"></i>

                                            </button>

                                        </form>

                                    @endcan

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#D46417]/10 text-2xl text-[#D46417]">

                                    <i class="fa-solid fa-money-bill-transfer"></i>

                                </div>

                                <h3 class="mt-4 font-bold">
                                    لا توجد معاملات مالية
                                </h3>

                                <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                                    لم يتم العثور على معاملات تطابق الفلاتر المحددة.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($transactions->hasPages())

            <div class="border-t border-[var(--color-border)] p-4">

                {{ $transactions->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
