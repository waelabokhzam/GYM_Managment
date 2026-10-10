<?php

namespace App\Services\Game;

use App\Models\Game;
use App\Models\User;
use App\Notifications\GameNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class UpdateGameService
{
    public function update(array $data, Game $game)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
        if ($game->getRawOriginal('image')) {
            Storage::disk('public')->delete($game->getRawOriginal('image'));
        }
        $data['image'] = $data['image']->store('games', 'public');
    } else {
        unset($data['image']); // إذا لم يُرفع شيء، نحافظ على القديمة
    }

    $timeSlotIds = $data['time_slots'] ?? [];
    unset($data['time_slots']);

    DB::transaction(function () use ($data, $timeSlotIds, $game) {
        $game->update($data);
        $game->timeSlots()->sync($timeSlotIds);
    });

        $users = User::where('id', '!=', Auth::id())->get();

        Notification::send(
            $users,
            new GameNotification(
                $game,
                'Update',
                Auth::user()
            )
        );

        return $game;
    }
}
