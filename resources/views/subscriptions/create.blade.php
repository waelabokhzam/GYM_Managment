@extends('layout.app')

@section('title','إضافة اشتراك')
@section('page-title','إضافة اشتراك')

@section('content')

<div class="max-w-4xl mx-auto">

<div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

<h2 class="mb-6 text-xl font-extrabold">إنشاء اشتراك جديد</h2>

<form method="POST" action="{{ route('subscriptions.store') }}" class="space-y-6">

@csrf

<div class="grid gap-6 md:grid-cols-2">

<div>
<label class="mb-2 block text-sm font-bold">اللاعب</label>

<select name="player_id" class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

<option value="">اختر لاعب</option>

@foreach($players as $player)

<option value="{{ $player->id }}">
{{ $player->user->fullname }} (#{{ $player->unique_number }})
</option>

@endforeach

</select>

</div>

<div>
<label class="mb-2 block text-sm font-bold">نوع الاشتراك</label>

<select name="sub_type" class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

<option value="monthly">شهري</option>
<option value="daily">يومي</option>
<option value="offers">عرض</option>
<option value="special">خاص</option>

</select>

</div>

<div>
<label class="mb-2 block text-sm font-bold">نوع التسجيل</label>

<select name="registration_type" class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

<option value="new">أول مرة</option>
<option value="renew">تجديد</option>

</select>

</div>

<div>
<label class="mb-2 block text-sm font-bold">تاريخ البداية</label>

<input type="date" name="start_date" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

</div>

</div>

<div class="flex justify-end gap-3">

<a href="{{ route('subscriptions.index') }}" class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">
إلغاء
</a>

<button class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white hover:bg-[#b95412]">
حفظ الاشتراك
</button>

</div>

</form>

</div>

</div>

@endsection