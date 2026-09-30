@extends('layout.app')

@section('title','تفاصيل الربط')
@section('page-title','تفاصيل الربط')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

<div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

<div class="flex items-center gap-4">

<div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#D46417] text-xl font-bold text-white">

{{ mb_substr($playerGame->player->user->fullname,0,1) }}

</div>

<div>

<h2 class="text-2xl font-extrabold">
{{ $playerGame->player->user->fullname }}
</h2>

<p class="text-[var(--color-text-muted)]">
{{ $playerGame->player->user->username }}
</p>

</div>

</div>

</div>

<div class="grid gap-5 md:grid-cols-3">

<div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

<p class="text-xs text-[var(--color-text-muted)]">
الرقم الخاص
</p>

<p class="mt-2 text-lg font-bold">
{{ $playerGame->player->unique_number }}
</p>

</div>

<div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

<p class="text-xs text-[var(--color-text-muted)]">
اللعبة
</p>

<p class="mt-2 text-lg font-bold">
{{ $playerGame->game->name }}
</p>

</div>

<div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

<p class="text-xs text-[var(--color-text-muted)]">
وصف اللعبة
</p>

<p class="mt-2 text-sm">
{{ $playerGame->game->description }}
</p>

</div>

</div>

<div class="flex justify-end gap-3">

<a href="{{ route('player-games.index') }}"
class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">

رجوع

</a>

@can('players.edit')

<a href="{{ route('player-games.edit',$playerGame) }}"
class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white transition hover:bg-[#b95412]">

تعديل

</a>

@endcan

</div>

</div>

@endsection