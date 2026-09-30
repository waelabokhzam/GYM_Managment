@extends('layout.app')

@section('title','ربط لاعب بلعبة')
@section('page-title','ربط لاعب بلعبة')

@section('content')

<div class="mx-auto max-w-3xl">

<div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

<h2 class="mb-6 text-xl font-extrabold">
ربط لاعب بلعبة
</h2>

<form method="POST" action="{{ route('player-games.store') }}" class="space-y-6">

@csrf

<div>

<label class="mb-2 block text-sm font-bold">
اللاعب
</label>

<select name="player_id"
class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

<option value="">اختر لاعب</option>

@foreach($players as $player)

<option value="{{ $player->id }}" @selected(old('player_id')==$player->id)>

{{ $player->user->fullname }}

({{ $player->unique_number }})

</option>

@endforeach

</select>

@error('player_id')
<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
@enderror

</div>

<div>

<label class="mb-2 block text-sm font-bold">
اللعبة
</label>

<select name="game_id"
class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

<option value="">اختر لعبة</option>

@foreach($games as $game)

<option value="{{ $game->id }}" @selected(old('game_id')==$game->id)>

{{ $game->name }}

</option>

@endforeach

</select>

@error('game_id')
<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
@enderror

</div>

<div class="flex justify-end gap-3">

<a href="{{ route('player-games.index') }}"
class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">

إلغاء

</a>

<button
class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white transition hover:bg-[#b95412]">

حفظ الربط

</button>

</div>

</form>

</div>

</div>

@endsection