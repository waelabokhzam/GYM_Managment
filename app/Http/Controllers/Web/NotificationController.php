<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function open(
        Request $request,
        string $notification
    ): RedirectResponse {
        // البحث ضمن إشعارات المستخدم الحالي فقط.
        $item = $request->user()
            ->notifications()
            ->whereKey($notification)
            ->firstOrFail();

        $item->markAsRead();

        $url = $item->data['url'] ?? null;

        // لا نسمح بإعادة التوجيه إلى موقع خارجي.
        if (! is_string($url) || $url === '') {
            return redirect()->route('dashboard');
        }

        $targetHost = parse_url($url, PHP_URL_HOST);
        $currentHost = $request->getHost();

        if ($targetHost !== null) {
            if (strcasecmp($targetHost, $currentHost) !== 0) {
                return redirect()->route('dashboard');
            }

            return redirect()->to($url);
        }

        // المسارات الداخلية فقط.
        if (! str_starts_with($url, '/') || str_starts_with($url, '//')) {
            return redirect()->route('dashboard');
        }

        return redirect()->to($url);
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        return back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة.');
    }
}
