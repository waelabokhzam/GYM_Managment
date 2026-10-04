<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimeSlot\StoreTimeSlotRequest;
use App\Http\Requests\TimeSlot\UpdateTimeSlotRequest;
use App\Models\TimeSlot;
use App\Services\TimeSlot\CreateTimeSlotService;
use App\Services\TimeSlot\DeleteTimeSlotService;
use App\Services\TimeSlot\IndexService;
use App\Services\TimeSlot\UpdateTimeSlotService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private IndexService $indexService,
        private CreateTimeSlotService $createTimeSlotService,
        private UpdateTimeSlotService $updateTimeSlotService,
        private DeleteTimeSlotService $deleteTimeSlotService
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', TimeSlot::class);

        return $this->indexService->index($request);
    }

    public function create()
    {
        $this->authorize('create', TimeSlot::class);

        return view('timeslot.create');
    }

    public function store(StoreTimeSlotRequest $request)
    {
        $this->authorize('create', TimeSlot::class);

        $this->createTimeSlotService->create(
            $request->validated()
        );

        return redirect()
            ->route('timeslots.index')
            ->with('success', 'تم إنشاء الفترة بنجاح.');
    }

    public function show(TimeSlot $timeslot)
    {
        $this->authorize('view', $timeslot);

        return view('timeslot.show', compact('timeslot'));
    }

    public function edit(TimeSlot $timeslot)
    {
        $this->authorize('update', $timeslot);

        return view('timeslot.edit', compact('timeslot'));
    }

    public function update(
        UpdateTimeSlotRequest $request,
        TimeSlot $timeslot
    ) {
        $this->authorize('update', $timeslot);

        $this->updateTimeSlotService->update(
            $request->validated(),
            $timeslot
        );

        return redirect()
            ->route('timeslots.show', $timeslot)
            ->with('success', 'تم تحديث الفترة بنجاح.');
    }

    public function destroy(TimeSlot $timeslot)
    {
        $this->authorize('delete', $timeslot);

        $this->deleteTimeSlotService->delete($timeslot);

        return redirect()
            ->route('timeslots.index')
            ->with('success', 'تم حذف الفترة بنجاح.');
    }
}