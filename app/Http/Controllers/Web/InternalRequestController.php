<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\InternalRequests\StoreInternalRequestRequest;
use App\Http\Requests\InternalRequests\UpdateInternalRequestRequest;
use App\Models\InternalRequest;
use App\Services\InternalRequests\InternalRequestService;
use Illuminate\Support\Facades\Gate;

class InternalRequestController extends Controller
{
    public function __construct(
        private InternalRequestService $service
    ) {}

    public function index()
    {
        Gate::authorize('viewAny', InternalRequest::class);

        $query = InternalRequest::with('requester.roles');

        /*
    |--------------------------------------------------------------------------
    | فلتر حسب صلاحية المستخدم
    |--------------------------------------------------------------------------
    */

        if (! auth()->user()->can('internal_requests.manage')) {

            $query->where(
                'requested_by',
                auth()->id()
            );
        }

        /*
    |--------------------------------------------------------------------------
    | فلتر نوع مقدم الطلب
    |--------------------------------------------------------------------------
    */

        if (request()->filled('role')) {

            $role = request('role');

            $query->whereHas('requester.roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        /*
    |--------------------------------------------------------------------------
    | فلتر حالة الطلب
    |--------------------------------------------------------------------------
    */

        if (request()->filled('status')) {

            $query->where(
                'status',
                request('status')
            );
        }

        /*
    |--------------------------------------------------------------------------
    | النتائج
    |--------------------------------------------------------------------------
    */

        $requests = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'internal_requests.index',
            compact('requests')
        );
    }

    public function create()
    {
        Gate::authorize('create', InternalRequest::class);

        return view('internal_requests.create');
    }

    public function store(StoreInternalRequestRequest $request)
    {
        $this->service->create(
            $request->validated()
        );

        return redirect()
            ->route('internal-requests.index')
            ->with('success', 'تم إرسال الطلب بنجاح.');
    }

    public function show(InternalRequest $internalRequest)
    {
        Gate::authorize('view', $internalRequest);

        $internalRequest->load('requester');

        return view(
            'internal_requests.show',
            compact('internalRequest')
        );
    }

    public function edit(InternalRequest $internalRequest)
    {
        Gate::authorize('update', $internalRequest);

        return view(
            'internal_requests.edit',
            compact('internalRequest')
        );
    }

    public function update(
        UpdateInternalRequestRequest $request,
        InternalRequest $internalRequest
    ) {

        $this->service->update(
            $internalRequest,
            $request->validated()
        );

        return redirect()
            ->route('internal-requests.index')
            ->with('success', 'تم تحديث الطلب.');
    }

    public function destroy(InternalRequest $internalRequest)
    {
        Gate::authorize('delete', $internalRequest);

        $this->service->delete($internalRequest);

        return redirect()
            ->route('internal-requests.index')
            ->with('success', 'تم حذف الطلب.');
    }
}
