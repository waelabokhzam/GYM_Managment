@extends('layout.app')

@section('title', 'تعديل إيصال')
@section('page-title', 'تعديل إيصال')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-extrabold">تعديل بيانات الإيصال</h2>
                <p class="mt-1 break-all font-mono text-xs text-[var(--color-text-muted)]" dir="ltr">
                    {{ $receipt->receipt_number }}</p>
            </div>
            <a href="{{ route('receipts.show', $receipt) }}"
                class="inline-flex items-center gap-2 self-start rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-semibold transition hover:bg-[var(--color-surface-hover)]">
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                تفاصيل الإيصال
            </a>
        </div>

        @include('receipt._form', ['receipt' => $receipt])
    </div>
@endsection