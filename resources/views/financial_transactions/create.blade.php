@extends('layout.app')

@section('title','إضافة حركة مالية')
@section('page-title','إضافة حركة مالية')

@section('content')

<div class="mx-auto max-w-3xl">

    <div class="mb-6">

        <h2 class="text-xl font-extrabold">
            تسجيل حركة مالية
        </h2>

        <p class="mt-1 text-sm text-[var(--color-text-muted)]">
            تسجيل عملية قبض أو صرف جديدة.
        </p>

    </div>


    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6">

        <form
            method="POST"
            action="{{ route('financial-transactions.store') }}"
            class="space-y-6"
        >

            @csrf


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

                    <option value="">
                        اختر نوع الحركة
                    </option>

                    <option
                        value="income"
                        @selected(old('transaction_type') === 'income')
                    >
                        قبض
                    </option>

                    @role('admin')

                        <option
                            value="expense"
                            @selected(old('transaction_type') === 'expense')
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

                <div class="relative">

                    <input
                        type="number"
                        name="amount"
                        value="{{ old('amount') }}"
                        min="0.01"
                        step="0.01"
                        required
                        placeholder="0.00"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none focus:border-[#D46417]"
                    >

                </div>

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
                    placeholder="اكتب سبب عملية القبض أو الصرف..."
                    class="w-full resize-none rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none focus:border-[#D46417]"
                >{{ old('description') }}</textarea>

                @error('description')

                    <p class="mt-2 text-xs font-bold text-red-500">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Info --}}
            <div class="rounded-xl border border-[#D46417]/20 bg-[#D46417]/5 p-4">

                <div class="flex items-start gap-3">

                    <i class="fa-solid fa-circle-info mt-0.5 text-[#D46417]"></i>

                    <div class="text-sm">

                        <p class="font-bold">
                            الموظف المعتمد
                        </p>

                        <p class="mt-1 text-[var(--color-text-muted)]">
                            سيتم تسجيل حسابك تلقائيًا كالموظف الذي قام باعتماد الحركة المالية.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Buttons --}}
            <div class="flex flex-wrap gap-3 pt-2">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#b95412]"
                >

                    <i class="fa-solid fa-check"></i>

                    تسجيل الحركة

                </button>

                <a
                    href="{{ route('financial-transactions.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--color-border)] px-6 py-3 text-sm font-bold transition hover:border-[#D46417] hover:text-[#D46417]"
                >

                    إلغاء

                </a>

            </div>

        </form>

    </div>

</div>

@endsection
