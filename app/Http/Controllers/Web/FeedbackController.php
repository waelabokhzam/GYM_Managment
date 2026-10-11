<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Services\Feedback\FeedbackService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function __construct(
        protected FeedbackService $feedbackService
    ) {}

    public function index(Request $request): View
{
    $search = $request->input('search');
    $status = $request->input('status');

    $feedbacks = $this->feedbackService->getPaginatedFeedbacks(
        perPage: 15,
        search: $search,
        status: $status
    );

    return view('feedbacks.index', compact('feedbacks', 'search', 'status'));
}

        public function show(Feedback $feedback)
    {
    // يمكنك تعديل حالة الملاحظة إلى "مقروءة" هنا تلقائياً إن أردت
    /*
    if ($feedback->status == 'unread') {
        $feedback->update(['status' => 'read']);
    }
    */

    return view('feedbacks.show', compact('feedback'));
    }

    public function updateStatus(Request $request, Feedback $feedback): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,read,resolved',
        ]);

        $this->feedbackService->updateFeedbackStatus($feedback, $request->status);

        return back()->with('success', 'تم تحديث حالة الملاحظة بنجاح.');
    }

}
