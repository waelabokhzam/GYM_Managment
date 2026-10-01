@extends('layout.app')

@section('title', 'تفاصيل الإيصال')
@section('page-title', 'تفاصيل الإيصال')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#D46417]/10 text-[#D46417]">
                        <i class="fa-solid fa-receipt" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold">تفاصيل الإيصال</h2>
                        <p class="mt-1 break-all font-mono text-xs text-[var(--color-text-muted)]" dir="ltr">
                            {{ $receipt->receipt_number }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('receipts.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-[var(--color-border)] px-4 py-2.5 text-sm font-semibold transition hover:bg-[var(--color-surface-hover)]">
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    القائمة
                </a>
                @can('reception.edit')
                    <a href="{{ route('receipts.edit', $receipt) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#D46417] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#b95412]">
                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                        تعديل
                    </a>
                @endcan
                @can('reception.delete')
                    <form method="POST" action="{{ route('receipts.destroy', $receipt) }}"
                        onsubmit="return confirm('هل تريد حذف هذا الإيصال؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg border border-red-500/30 px-4 py-2.5 text-sm font-semibold text-red-500 transition hover:bg-red-500/10">
                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                            حذف
                        </button>
                    </form>
                @endcan
            </div>
        </div>

        <section class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)]">
            <div
                class="flex flex-col gap-2 border-b border-[var(--color-border)] bg-[var(--color-background)] px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <h3 class="font-bold">معلومات الدفع</h3>
                <span
                    class="text-sm text-[var(--color-text-muted)]">{{ $receipt->payment_date?->format('Y-m-d H:i') ?? '—' }}</span>
            </div>

            <dl class="grid grid-cols-1 divide-y divide-[var(--color-border)] sm:grid-cols-2 sm:divide-y-0">
                <div class="space-y-1 px-5 py-4 sm:px-6">
                    <dt class="text-sm text-[var(--color-text-muted)]">المبلغ</dt>
                    <dd class="text-lg font-extrabold">{{ number_format((float) $receipt->amount, 2) }}</dd>
                </div>
                <div class="space-y-1 px-5 py-4 sm:border-r sm:border-[var(--color-border)] sm:px-6">
                    <dt class="text-sm text-[var(--color-text-muted)]">تاريخ الدفع</dt>
                    <dd class="font-semibold">{{ $receipt->payment_date?->format('Y-m-d') ?? '—' }}</dd>
                </div>
                <div class="space-y-1 border-t border-[var(--color-border)] px-5 py-4 sm:px-6">
                    <dt class="text-sm text-[var(--color-text-muted)]">اللاعب</dt>
                    <dd class="font-semibold">{{ $receipt->player?->user?->fullname ?? 'غير محدد' }}</dd>
                    @if ($receipt->player?->unique_number)
                        <dd class="text-xs text-[var(--color-text-muted)]">رقم اللاعب: #{{ $receipt->player->unique_number }}
                        </dd>
                    @endif
                </div>
                <div class="space-y-1 border-t border-[var(--color-border)] px-5 py-4 sm:border-r sm:px-6">
                    <dt class="text-sm text-[var(--color-text-muted)]">اللعبة</dt>
                    <dd class="font-semibold">{{ $receipt->game?->name ?? 'غير محددة' }}</dd>
                </div>
                <div class="space-y-1 border-t border-[var(--color-border)] px-5 py-4 sm:px-6">
                    <dt class="text-sm text-[var(--color-text-muted)]">الاشتراك</dt>
                    @if ($receipt->subscription)
                        @php
                            $subscriptionTypes = [
                                'monthly' => 'شهري',
                                'daily' => 'يومي',
                                'offers' => 'عرض',
                                'special' => 'خاص',
                            ];
                        @endphp
                        <dd class="font-semibold">
                            {{ $subscriptionTypes[$receipt->subscription->sub_type] ?? $receipt->subscription->sub_type }}
                            · {{ $receipt->subscription->start_date?->format('Y-m-d') }} –
                            {{ $receipt->subscription->end_date?->format('Y-m-d') }}
                        </dd>
                        <dd class="text-xs text-[var(--color-text-muted)]">
                            {{ $receipt->subscription->player?->user?->fullname ?? '' }}</dd>
                    @else
                        <dd class="font-semibold">غير محدد</dd>
                    @endif
                </div>
                <div class="space-y-1 border-t border-[var(--color-border)] px-5 py-4 sm:border-r sm:px-6">
                    <dt class="text-sm text-[var(--color-text-muted)]">استلمه</dt>
                    <dd class="font-semibold">{{ $receipt->receivedBy?->user?->fullname ?? 'غير محدد' }}</dd>
                </div>
                <div class="space-y-1 border-t border-[var(--color-border)] px-5 py-4 sm:px-6">
                    <dt class="text-sm text-[var(--color-text-muted)]">تاريخ إنشاء السجل</dt>
                    <dd class="font-semibold">{{ $receipt->created_at?->format('Y-m-d H:i') ?? '—' }}</dd>
                </div>
                <div class="space-y-1 border-t border-[var(--color-border)] px-5 py-4 sm:border-r sm:px-6">
                    <dt class="text-sm text-[var(--color-text-muted)]">آخر تحديث</dt>
                    <dd class="font-semibold">{{ $receipt->updated_at?->format('Y-m-d H:i') ?? '—' }}</dd>
                </div>
            </dl>
        </section>
    </div>
@endsection