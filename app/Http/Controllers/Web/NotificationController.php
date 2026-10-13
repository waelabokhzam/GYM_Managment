<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    
public function open(Request $request, string $notification): RedirectResponse
{
    $item = $request->user()
        ->notifications()
        ->whereKey($notification)
        ->firstOrFail();

    $item->markAsRead();

    $data = $item->data;

    // إذا كان الإشعار مرتبطاً بلاعب، افتح صفحة اللاعب مباشرة.
    if (! empty($data['player_id'])) {
        return redirect()->route(
            'players.show',
            $data['player_id']
        );
    }

    $url = $data['url'] ?? null;

    if (! is_string($url) || $url === '') {
        return redirect()->route('dashboard');
    }

    // استخراج المسار الداخلي لتجنب مشكلة اختلاف localhost
    // عن عنوان الموقع الحالي.
    $path = parse_url($url, PHP_URL_PATH);
    $query = parse_url($url, PHP_URL_QUERY);

    if (
        ! is_string($path) ||
        ! str_starts_with($path, '/') ||
        str_starts_with($path, '//')
    ) {
        return redirect()->route('dashboard');
    }

    if (is_string($query) && $query !== '') {
        $path .= '?' . $query;
    }

    return redirect()->to($path);
}

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        return back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة.');
    }
}
