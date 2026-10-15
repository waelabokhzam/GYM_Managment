<?php

namespace App\Notifications\Concerns;

trait SendsToMobile
{
    /**
     * بيبني رسالة الـ push من نفس بيانات toArray()، فما منكتبها مرتين.
     * الشرط: toArray() لازم يرجع type و title و message.
     */
    public function toFcm(object $notifiable): array
    {
        $data = $this->toArray($notifiable);

        return [
            'title' => $data['title'],
            'body' => $data['message'],
            'data' => [
                'type' => $data['type'],
                'notification_id' => $this->id,
            ],
        ];
    }
}
