<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\SubscriptionBalanceReminderNotification;
use App\Notifications\SubscriptionCreatedNotification;
use App\Notifications\SubscriptionExpiringNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    private const MOBILE_TYPES = [
        SubscriptionCreatedNotification::class,
        SubscriptionExpiringNotification::class,
        SubscriptionBalanceReminderNotification::class,
    ];

    public function index(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->notifications()
            ->whereIn('type', self::MOBILE_TYPES)
            ->latest()
            ->limit(50)
            ->get()
            ->map(fn (DatabaseNotification $n) => $this->format($n))
            ->values();

        return response()->json([
            'success' => true,
            'data' => $notifications,
        ]);
    }

    public function markAsRead(Request $request, string $id): JsonResponse
    {
        $notification = $request->user()
            ->notifications()
            ->whereIn('type', self::MOBILE_TYPES)
            ->whereKey($id)
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(Request $request): JsonResponse
    {
        $request->user()
            ->unreadNotifications()
            ->whereIn('type', self::MOBILE_TYPES)
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    private function format(DatabaseNotification $n): array
    {
        return [
            'id' => $n->id,
            'type' => $n->data['type'] ?? 'general',
            'title' => $n->data['title'] ?? '',
            'body' => $n->data['message'] ?? '',
            'created_at' => $n->created_at->toIso8601String(),
            'read_at' => $n->read_at?->toIso8601String(),
        ];
    }
}
