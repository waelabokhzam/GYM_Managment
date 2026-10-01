@extends('layout.app')

@section('title','تفاصيل الطلب')
@section('page-title','تفاصيل الطلب')

@section('content')

<div class="mx-auto max-w-5xl space-y-6">

<div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

<div class="flex items-center gap-4">

<div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#D46417] text-xl font-bold text-white">

{{ mb_substr($internalRequest->requester->fullname,0,1) }}

</div>

<div>

<h2 class="text-2xl font-extrabold">

{{ $internalRequest->requester->fullname }}

</h2>

<p class="text-[var(--color-text-muted)]">

{{ $internalRequest->requester->username }}

</p>

</div>

</div>

</div>

<div class="grid gap-5 md:grid-cols-3">

<div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

<p class="text-xs text-[var(--color-text-muted)]">

تاريخ الإنشاء

</p>

<p class="mt-2 text-lg font-bold">

{{ $internalRequest->created_at->format('Y-m-d') }}

</p>

</div>

<div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

<p class="text-xs text-[var(--color-text-muted)]">

آخر تحديث

</p>

<p class="mt-2 text-lg font-bold">

{{ $internalRequest->updated_at->format('Y-m-d') }}

</p>

</div>

<div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

<p class="text-xs text-[var(--color-text-muted)]">

الحالة

</p>

<p class="mt-2">

@switch($internalRequest->status)

@case('pending')

<span class="rounded-lg bg-yellow-500/10 px-3 py-1.5 text-xs font-bold text-yellow-500">

قيد الانتظار

</span>

@break

@case('approved')

<span class="rounded-lg bg-green-500/10 px-3 py-1.5 text-xs font-bold text-green-500">

تمت الموافقة

</span>

@break

@case('rejected')

<span class="rounded-lg bg-red-500/10 px-3 py-1.5 text-xs font-bold text-red-500">

مرفوض

</span>

@break

@case('postponed')

<span class="rounded-lg bg-orange-500/10 px-3 py-1.5 text-xs font-bold text-orange-500">

مؤجل

</span>

@break

@endswitch

</p>

</div>

</div>

<div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

<h3 class="mb-4 text-lg font-extrabold">

تفاصيل الطلب

</h3>

<div class="rounded-2xl bg-[var(--color-background)] p-5 leading-8 whitespace-pre-line">

{{ $internalRequest->details }}

</div>

</div>

<div class="flex justify-end gap-3">

<a href="{{ route('internal-requests.index') }}"
class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">

رجوع

</a>

@can('update',$internalRequest)

<a href="{{ route('internal-requests.edit',$internalRequest) }}"
class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white transition hover:bg-[#b95412]">

تعديل

</a>

@endcan

</div>

</div>

@endsection