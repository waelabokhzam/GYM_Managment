<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerTime\StoreTrainerTimeSlotRequest;
use App\Http\Requests\TrainerTime\UpdateTrainerTimeSlotRequest;
use App\Models\Staff;
use App\Models\TimeSlot;
use App\Models\TrainerTimeSlot;
use App\Services\TrainerTime\TrainerTimeSlotService;
use Illuminate\Support\Facades\Gate;


class TrainerTimeSlotController extends Controller
{
    public function __construct(
        private TrainerTimeSlotService $service
    ) {}

    public function index()
    {
        Gate::authorize('viewAny', TrainerTimeSlot::class);

        $trainerTimeSlots = TrainerTimeSlot::with([
            'trainer.user',
            'timeSlot'
        ])->paginate(10);

        return view(
            'trainer_time_slots.index',
            compact('trainerTimeSlots')
        );
    }

    public function create()
    {
        Gate::authorize('create', TrainerTimeSlot::class);

        $trainers = Staff::where('role', 'trainer')
            ->with('user')
            ->get();

        $timeSlots = TimeSlot::all();

        return view(
            'trainer_time_slots.create',
            compact('trainers', 'timeSlots')
        );
    }

    public function store(StoreTrainerTimeSlotRequest $request)
    {
        $this->service->create(
            $request->validated()
        );

        return redirect()
            ->route('trainer-time-slots.index')
            ->with('success', 'تم الربط بنجاح.');
    }

    public function show(TrainerTimeSlot $trainerTimeSlot)
    {
        Gate::authorize('view', $trainerTimeSlot);

        $trainerTimeSlot->load([
            'trainer.user',
            'timeSlot'
        ]);

        return view(
            'trainer_time_slots.show',
            compact('trainerTimeSlot')
        );
    }

    public function edit(TrainerTimeSlot $trainerTimeSlot)
    {
        Gate::authorize('update', $trainerTimeSlot);

        $trainers = Staff::where('role', 'trainer')
            ->with('user')
            ->get();

        $timeSlots = TimeSlot::all();

        return view(
            'trainer_time_slots.edit',
            compact(
                'trainerTimeSlot',
                'trainers',
                'timeSlots'
            )
        );
    }

    public function update(
        UpdateTrainerTimeSlotRequest $request,
        TrainerTimeSlot $trainerTimeSlot
    ) {

        $this->service->update(
            $trainerTimeSlot,
            $request->validated()
        );

        return redirect()
            ->route('trainer-time-slots.index')
            ->with('success', 'تم التحديث.');
    }

    public function destroy(TrainerTimeSlot $trainerTimeSlot)
    {
        Gate::authorize('delete', $trainerTimeSlot);

        $this->service->delete($trainerTimeSlot);

        return redirect()
            ->route('trainer-time-slots.index')
            ->with('success', 'تم الحذف.');
    }
}