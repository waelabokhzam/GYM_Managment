@extends('layout.app')

@section('title','تفاصيل الاشتراك')
@section('page-title','تفاصيل الاشتراك')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

<div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

<div class="flex items-center gap-4">

<div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#D46417] text-xl font-bold text-white">
{{ mb_substr($subscription->player->user->fullname,0,1) }}
</div>

<div>

<h2 class="text-2xl font-extrabold">
{{ $subscription->player->user->fullname }}
</h2>

<p class="text-[var(--color-text-muted)]">
رقم اللاعب: {{ $subscription->player->unique_number }}
</p>

</div>

</div>

</div>

<div class="grid gap-5 md:grid-cols-3">

@php
$items=[
'نوع الاشتراك'=>$subscription->sub_type,
'نوع التسجيل'=>$subscription->registration_type,
'الحالة'=>$subscription->status,
'تاريخ البداية'=>$subscription->start_date->format('Y-m-d'),
'تاريخ النهاية'=>$subscription->end_date->format('Y-m-d'),
'المدة المتبقية'=>$subscription->end_date->isFuture()?$subscription->end_date->diffInDays(now()).' يوم':'منتهي',
];
@endphp

@foreach($items as $title=>$value)

<div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

<p class="text-xs text-[var(--color-text-muted)]">{{ $title }}</p>

<p class="mt-2 text-lg font-bold">{{ $value }}</p>

</div>

@endforeach

</div>

<div class="flex justify-end gap-3">

<a href="{{ route('subscriptions.index') }}" class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">
رجوع
</a>

@can('subscriptions.edit')

<a href="{{ route('subscriptions.edit',$subscription) }}" class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white">
تعديل
</a>

@endcan

</div>

</div>

@endsection