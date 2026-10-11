<?php
namespace App\Services\Feedback;

use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FeedbackService
{
    /**
     * حفظ ملاحظة جديدة
     */
    public function hasRecentFeedback(int $userId, int $minutes = 5): bool
    {
        return Feedback::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subMinutes($minutes))
            ->exists();
    }

    public function storeFeedback(int $userId, array $data): Feedback
    {
        return Feedback::create([
            'user_id' => $userId,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status'  => 'pending',
        ]);
    }

    /**
     * جلب قائمة الملاحظات مع Pagination للـ Admin
     */
    public function getPaginatedFeedbacks(int $perPage = 15, ?string $search = null, ?string $status = null): LengthAwarePaginator
{
    return Feedback::with('user:id,fullname,username,phone')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('fullname', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        })
        ->when($status, function ($query, $status) {
            $query->where('status', $status);
        })
        ->latest()
        ->paginate($perPage)
        ->withQueryString(); // للحفاظ على متغيرات البحث عند التنقل بين صفحات الـ Pagination
}

    /**
     * تحديث حالة الملاحظة
     */
    public function updateFeedbackStatus(Feedback $feedback, string $status): Feedback
    {
        $feedback->update([
            'status' => $status,
        ]);

        return $feedback;
    }


}
