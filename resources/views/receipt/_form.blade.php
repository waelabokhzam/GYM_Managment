@php
    $isEditing = $receipt !== null;
    $subscriptionTypes = [
        'monthly' => 'شهري',
        'daily' => 'يومي',
        'offers' => 'عرض',
        'special' => 'خاص',
    ];
@endphp

<form method="POST" action="{{ $isEditing ? route('receipts.update', $receipt) : route('receipts.store') }}"
    class="space-y-6 rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 sm:p-7">
    @csrf
    @if ($isEditing)
        @method('PUT')
    @endif
    <input type="hidden" name="received_by" value="{{ auth()->user()->staff?->id }}">

    @if ($errors->any())
        <div class="rounded-lg border border-red-500/30 bg-red-500/5 p-4 text-sm text-red-500" role="alert">
            <p class="font-bold">تعذر حفظ الإيصال. راجع الحقول التالية:</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
        <label class="space-y-2">
            <span class="block text-sm font-bold">اللاعب <span class="text-red-500">*</span></span>
            <select id="receipt-player" name="player_id" required
                class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-3 text-sm outline-none focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
                <option value="">اختر اللاعب</option>
                @foreach ($players as $player)
                    <option value="{{ $player->id }}" @selected((string) old('player_id', $receipt?->player_id) === (string) $player->id)>
                        {{ $player->user?->fullname ?? 'بدون اسم' }} (#{{ $player->unique_number }})
                    </option>
                @endforeach
            </select>
            @error('player_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </label>

        <label class="space-y-2">
            <span class="block text-sm font-bold">الاشتراك <span class="text-red-500">*</span></span>
            <select id="receipt-subscription" name="subscription_id" required
                class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-3 text-sm outline-none focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
                <option value="">اختر اشتراك اللاعب</option>
                @foreach ($subscriptions as $subscription)
                    <option value="{{ $subscription->id }}" data-player-id="{{ $subscription->player_id }}"
                        @selected((string) old('subscription_id', $receipt?->subscription_id) === (string) $subscription->id)>
                        {{ $subscription->player?->user?->fullname ?? 'لاعب غير معروف' }} ·
                        {{ $subscriptionTypes[$subscription->sub_type] ?? $subscription->sub_type }} ·
                        {{ $subscription->start_date?->format('Y-m-d') }}
                    </option>
                @endforeach
            </select>
            @error('subscription_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </label>

        <label class="space-y-2">
            <span class="block text-sm font-bold">اللعبة <span class="text-red-500">*</span></span>
            <select name="game_id" required
                class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-3 text-sm outline-none focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
                <option value="">اختر اللعبة</option>
                @foreach ($games as $game)
                    <option value="{{ $game->id }}" @selected((string) old('game_id', $receipt?->game_id) === (string) $game->id)>
                        {{ $game->name }}
                    </option>
                @endforeach
            </select>
            @error('game_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </label>

        <label class="space-y-2">
            <span class="block text-sm font-bold">المبلغ <span class="text-red-500">*</span></span>
            <input type="number" name="amount" value="{{ old('amount', $receipt?->amount) }}" step="1" required
                class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-3 text-sm outline-none focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10"
                placeholder="أدخل المبلغ">
            @error('amount') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </label>

        <label class="space-y-2 sm:col-span-2">
            <span class="block text-sm font-bold">تاريخ الدفع <span class="text-red-500">*</span></span>
            <input type="datetime-local" name="payment_date"
                value="{{ old('payment_date', $receipt?->payment_date?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i')) }}"
                required
                class="w-full rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-3 text-sm outline-none focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10 sm:max-w-md">
            @error('payment_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </label>
    </div>

    <div class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)] pt-5 sm:flex-row sm:justify-end">
        <a href="{{ $isEditing ? route('receipts.show', $receipt) : route('receipts.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-[var(--color-border)] px-5 py-3 text-sm font-semibold transition hover:bg-[var(--color-surface-hover)]">
            إلغاء
        </a>
        <button type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#D46417] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#b95412]">
            <i class="fa-solid fa-check" aria-hidden="true"></i>
            {{ $isEditing ? 'حفظ التعديلات' : 'إنشاء الإيصال' }}
        </button>
    </div>
</form>

@push('scripts')
    <script>
        (() => {
            const playerSelect = document.getElementById('receipt-player');
            const subscriptionSelect = document.getElementById('receipt-subscription');

            if (!playerSelect || !subscriptionSelect) {
                return;
            }

            const syncSubscriptions = () => {
                const playerId = playerSelect.value;
                const selectedOption = subscriptionSelect.selectedOptions[0];

                for (const option of subscriptionSelect.querySelectorAll('option[data-player-id]')) {
                    option.disabled = Boolean(playerId) && option.dataset.playerId !== playerId;
                }

                if (selectedOption?.dataset.playerId && selectedOption.dataset.playerId !== playerId) {
                    subscriptionSelect.value = '';
                }
            };

            playerSelect.addEventListener('change', syncSubscriptions);
            syncSubscriptions();
        })();
    </script>
@endpush