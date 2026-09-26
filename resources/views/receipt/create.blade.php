@extends('layout.app')

@section('title', 'إضافة إيصال')
@section('page-title', 'إضافة إيصال')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-extrabold">إنشاء إيصال جديد</h2>
                <p class="mt-1 text-sm text-[var(--color-text-muted)]">أدخل بيانات الدفعة لربطها باللاعب واشتراكه.</p>
            </div>
            <a href="{{ route('receipts.index') }}"
                class="inline-flex items-center gap-2 self-start rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-semibold transition hover:bg-[var(--color-surface-hover)]">
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                العودة للإيصالات
            </a>
        </div>

        @include('receipt._form', ['receipt' => null])
    </div>
@endsection