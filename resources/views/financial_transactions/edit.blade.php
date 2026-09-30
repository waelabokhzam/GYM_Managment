@extends('layout.app')

@section('title','تعديل الحركة المالية')
@section('page-title','تعديل الحركة المالية')

@section('content')

<div class="mx-auto max-w-3xl">

    <div class="mb-6">

        <h2 class="text-xl font-extrabold">
            تعديل الحركة المالية
        </h2>

        <p class="mt-1 text-sm text-[var(--color-text-muted)]">
            تعديل بيانات الحركة المالية المحددة.
        </p>

    </div>


    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

        <form
            method="POST"
            action="{{ route('financial-transactions.update', $financialTransaction) }}"
            class="space-y-6"
        >

            @csrf
            @method('PUT')


            {{-- Type --}}
            <div>

                <label class="mb-2 block text-sm font-bold">
                    نوع الحركة
                </label>

                <select
                    name="transaction_type"
                    required
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none focus:border-[#D46417]"
                >

                    <option
                        value="income"
                        @selected(old(
                            'transaction_type',
                            $financialTransaction->transaction_type
                        ) === 'income')
                    >
                        قبض
                    </option>

                    @role('admin')

                        <option
                            value="expense"
                            @selected(old(
                                'transaction_type',
                                $financialTransaction->transaction_type
                            ) === 'expense')
                        >
                            صرف
                        </option>

                    @endrole

                </select>

                @error('transaction_type')

                    <p class="mt-2 text-xs font-bold text-red-500">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Amount --}}
            <div>

                <label class="mb-2 block text-sm font-bold">
                    قيمة المبلغ
                </label>

                <input
                    type="number"
                    name="amount"
                    value="{{ old('amount', $financialTransaction->amount) }}"
                    min="0.01"
                    step="0.01"
                    required
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none focus:border-[#D46417]"
                >

                @error('amount')

                    <p class="mt-2 text-xs font-bold text-red-500">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Description --}}
            <div>

                <label class="mb-2 block text-sm font-bold">
                    سبب الحركة المالية
                </label>

                <textarea
                    name="description"
                    rows="5"
                    required
                    class="w-full resize-none rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none focus:border-[#D46417]"
                >{{ old('description', $financialTransaction->description) }}</textarea>

                @error('description')

                    <p class="mt-2 text-xs font-bold text-red-500">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Approver --}}
            <div class="rounded-xl bg-[var(--color-background)] p-4">

                <p class="text-xs font-bold text-[var(--color-text-muted)]">
                    الموظف المعتمد الأصلي
                </p>

                <p class="mt-1 font-bold">

                    {{ $financialTransaction->approver?->fullname ?? '—' }}

                </p>

            </div>


            {{-- Buttons --}}
            <div class="flex flex-wrap gap-3">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#b95412]"
                >

                    <i class="fa-solid fa-floppy-disk"></i>

                    حفظ التعديلات

                </button>

                <a
                    href="{{ route('financial-transactions.show', $financialTransaction) }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--color-border)] px-6 py-3 text-sm font-bold transition hover:border-[#D46417] hover:text-[#D46417]"
                >

                    إلغاء

                </a>

            </div>

        </form>

    </div>

</div>

@endsection