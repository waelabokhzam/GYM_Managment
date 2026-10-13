<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FcmNotification;
use Throwable;

class FcmChannel
{
    public function send(object $notifiable, Notification $notification): void
    {
        // الإشعارات يلي ما عندها toFcm() (متل Game و TimeSlot) بتضل للداشبورد بس
        if (! method_exists($notification, 'toFcm')) {
            return;
        }

        try {
            $tokens = $notifiable->deviceTokens()->pluck('token')->all();

            if ($tokens === []) {
                Log::info('FCM skipped: no device tokens', ['user_id' => $notifiable->id]);
                return;
            }

            $payload = $notification->toFcm($notifiable);

            $message = CloudMessage::new()
                ->withNotification(
                    FcmNotification::create($payload['title'], $payload['body'])
                )
                ->withData($this->stringify($payload['data'] ?? []))
                ->withAndroidConfig(['priority' => 'high']);

            /** @var Messaging $messaging */
            $messaging = app(Messaging::class);

            $report = $messaging->sendMulticast($message, $tokens);

            Log::info('FCM sent', [
                'user_id' => $notifiable->id,
                'tokens' => count($tokens),
                'success' => $report->successes()->count(),
                'failed' => $report->failures()->count(),
            ]);

            foreach ($report->failures()->getItems() as $failure) {
                Log::warning('FCM token failure: ' . ($failure->error()?->getMessage() ?? 'unknown'));
            }

            // نحذف الـ tokens يلي Google بتقول إنها مش صالحة
            $dead = array_merge($report->invalidTokens(), $report->unknownTokens());

            if ($dead !== []) {
                $notifiable->deviceTokens()->whereIn('token', $dead)->delete();
            }
        } catch (Throwable $e) {
            Log::warning('FCM send failed: ' . $e->getMessage());
        }
    }

    private function stringify(array $data): array
    {
        return array_map(
            fn ($value) => (string) $value,
            array_filter($data, fn ($value) => $value !== null)
        );
    }
}
