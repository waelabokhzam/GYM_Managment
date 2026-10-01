@extends('layout.app')

@section('title','تفاصيل الحركة المالية')
@section('page-title','تفاصيل الحركة المالية')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h2 class="text-xl font-extrabold">
                تفاصيل الحركة المالية
            </h2>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                عرض تفاصيل عملية القبض أو الصرف.
            </p>

        </div>

        <div class="flex gap-2">

            @can('update', $financialTransaction)

                <a
                    href="{{ route('financial-transactions.edit', $financialTransaction) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#b95412]"
                >

                    <i class="fa-solid fa-pen"></i>

                    تعديل

                </a>

            @endcan

            <a
                href="{{ route('financial-transactions.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-[var(--color-border)] px-5 py-3 text-sm font-bold transition hover:border-[#D46417] hover:text-[#D46417]"
            >

                <i class="fa-solid fa-arrow-right"></i>

                العودة

            </a>

        </div>

    </div>


    {{-- Main Card --}}
    <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        {{-- Type --}}
        <div class="border-b border-[var(--color-border)] p-6">

            <div class="flex items-center justify-between gap-4">

                <div>

                    <p class="text-xs font-bold text-[var(--color-text-muted)]">
                        نوع الحركة
                    </p>

                    <div class="mt-2">

                        @if($financialTransaction->transaction_type === 'income')

                            <span class="inline-flex items-center gap-2 rounded-xl bg-green-500/10 px-4 py-2 text-sm font-bold text-green-500">

                                <i class="fa-solid fa-arrow-down"></i>

                                قبض

                            </span>

                        @else

                            <span class="inline-flex items-center gap-2 rounded-xl bg-red-500/10 px-4 py-2 text-sm font-bold text-red-500">

                                <i class="fa-solid fa-arrow-up"></i>

                                صرف

                            </span>

                        @endif

                    </div>

                </div>


                <div class="text-left">

                    <p class="text-xs font-bold text-[var(--color-text-muted)]">
                        المبلغ
                    </p>

                    <p class="mt-1 text-2xl font-extrabold">

                        {{ number_format($financialTransaction->amount, 2) }}

                    </p>

                </div>

            </div>

        </div>


        {{-- Details --}}
        <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">

            {{-- Description --}}
            <div class="md:col-span-2">

                <p class="text-xs font-bold text-[var(--color-text-muted)]">
                    سبب الحركة المالية
                </p>

                <div class="mt-2 rounded-xl bg-[var(--color-background)] p-4 leading-7">

                    {{ $financialTransaction->description }}

                </div>

            </div>


            {{-- Approver --}}
            <div>

                <p class="text-xs font-bold text-[var(--color-text-muted)]">
                    الموظف المعتمد
                </p>

                <div class="mt-2 flex items-center gap-3">

                    @if($financialTransaction->approver)

                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#D46417] font-bold text-white">

                            {{ mb_substr($financialTransaction->approver->fullname, 0, 1) }}

                        </div>

                        <div>

                            <p class="font-bold">

                                {{ $financialTransaction->approver->fullname }}

                            </p>

                            <p class="text-xs text-[var(--color-text-muted)]">

                                {{ $financialTransaction->approver->username }}

                            </p>

                        </div>

                    @else

                        <span>
                            —
                        </span>

                    @endif

                </div>

            </div>


            {{-- Created --}}
            <div>

                <p class="text-xs font-bold text-[var(--color-text-muted)]">
                    تاريخ التسجيل
                </p>

                <p class="mt-2 font-bold">

                    {{ $financialTransaction->created_at->format('Y-m-d H:i') }}

                </p>

            </div>


            {{-- Updated --}}
            <div>

                <p class="text-xs font-bold text-[var(--color-text-muted)]">
                    آخر تعديل
                </p>

                <p class="mt-2 font-bold">

                    {{ $financialTransaction->updated_at->format('Y-m-d H:i') }}

                </p>

            </div>

        </div>

    </div>


    {{-- Delete --}}
    @can('delete', $financialTransaction)

        <div class="flex justify-end">

            <form
                method="POST"
                action="{{ route('financial-transactions.destroy', $financialTransaction) }}"
                onsubmit="return confirm('هل أنت متأكد من حذف هذه الحركة المالية؟ لا يمكن التراجع عن هذه العملية.');"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl border border-red-500/30 px-5 py-3 text-sm font-bold text-red-500 transition hover:bg-red-500/10"
                >

                    <i class="fa-solid fa-trash"></i>

                    حذف الحركة

                </button>

            </form>

        </div>

    @endcan

</div>

@endsection
