<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feedback\StoreFeedbackRequest;
use App\Services\Feedback\FeedbackService;
use Illuminate\Http\JsonResponse;

class FeedbackController extends Controller
{
    public function __construct(
        protected FeedbackService $feedbackService
    ) {}


public function store(StoreFeedbackRequest $request): JsonResponse
{
    // 1. فحص التكرار خلال 5 دقائق
    if ($this->feedbackService->hasRecentFeedback($request->user()->id, 5)) {
        return response()->json([
            'status'  => false,
            'message' => 'لقد أرسلت ملاحظة مؤخراً. يرجى الانتظار 5 دقائق قبل إرسال ملاحظة جديدة.',
        ], 429);
    }

    // 2. البيانات المفلترة والمحققة تلقائياً
    $feedback = $this->feedbackService->storeFeedback(
        $request->user()->id,
        $request->validated()
    );

    return response()->json([
        'status'  => true,
        'message' => 'تم إرسال ملاحظتك بنجاح، شكراً لك.',
        'data'    => $feedback,
    ], 201);
}
}
