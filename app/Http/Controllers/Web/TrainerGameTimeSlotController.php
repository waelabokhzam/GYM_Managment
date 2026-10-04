<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerGameTimeSlot\StoreTrainerGameTimeSlotRequest;
use App\Http\Requests\TrainerGameTimeSlot\UpdateTrainerGameTimeSlotRequest;
use App\Models\Game;
use App\Models\Staff;
use App\Models\TimeSlot;
use App\Models\TrainerGameTimeSlot;
use App\Services\TrainerGameTimeSlot\CreateTrainerGameTimeSlotService;
use App\Services\TrainerGameTimeSlot\DeleteTrainerGameTimeSlotService;
use App\Services\TrainerGameTimeSlot\UpdateTrainerGameTimeSlotService;
use Illuminate\Http\Request;

class TrainerGameTimeSlotController extends Controller
{
    public function __construct(
        private CreateTrainerGameTimeSlotService $createService,
        private UpdateTrainerGameTimeSlotService $updateService,
        private DeleteTrainerGameTimeSlotService $deleteService,
    ) {
    }

    /**
     * عرض جميع تعيينات المدربين.
     */
    public function index(Request $request)
    {
        $assignments = TrainerGameTimeSlot::query()
            ->with([
                'trainer.user',
                'game',
                'timeSlot',
            ])
            ->when(
                $request->staff_id,
                fn ($query) =>
                    $query->where('staff_id', $request->staff_id)
            )
            ->when(
                $request->game_id,
                fn ($query) =>
                    $query->where('game_id', $request->game_id)
            )
            ->when(
                $request->time_slot_id,
                fn ($query) =>
                    $query->where(
                        'time_slot_id',
                        $request->time_slot_id
                    )
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $trainers = Staff::query()
            ->where('role', 'trainer')
            ->with('user')
            ->get();

        $games = Game::query()
            ->orderBy('name')
            ->get();

        $timeSlots = TimeSlot::query()
            ->orderBy('start_time')
            ->get();

        return view(
            'trainer-game-time-slot.index',
            compact(
                'assignments',
                'trainers',
                'games',
                'timeSlots'
            )
        );
    }

    /**
     * عرض صفحة إضافة تعيين جديد.
     */
    public function create()
{
    $trainers = Staff::query()
        ->where('role', 'trainer')
        ->with('user')
        ->orderBy('id')
        ->get();

    $games = Game::query()
        ->orderBy('name')
        ->get();

    $timeSlots = TimeSlot::query()
        ->with('games')
        ->orderBy('start_time')
        ->get();

    $timeSlotsData = $timeSlots->map(function ($slot) {
        return [
            'id' => $slot->id,
            'name' => $slot->name,
            'start_time' => \Carbon\Carbon::parse($slot->start_time)->format('H:i'),
            'end_time' => \Carbon\Carbon::parse($slot->end_time)->format('H:i'),
            'games' => $slot->games->map(function ($game) {
                return [
                    'id' => $game->id,
                    'name' => $game->name,
                ];
            })->values()->toArray(),
        ];
    })->values()->toArray();

    return view(
        'trainer-game-time-slot.create',
        compact(
            'trainers',
            'games',
            'timeSlots',
            'timeSlotsData'
        )
    );
}

    /**
     * حفظ التعيين.
     */
    public function store(
        StoreTrainerGameTimeSlotRequest $request
    ) {
        $this->createService->create(
            $request->validated()
        );

        return redirect()
            ->route('trainer-game-time-slots.index')
            ->with(
                'success',
                'تم تعيين المدرب للعبة والفترة التدريبية بنجاح.'
            );
    }

    /**
     * عرض تفاصيل التعيين.
     */
    public function show(
        TrainerGameTimeSlot $trainerGameTimeSlot
    ) {
        $trainerGameTimeSlot->load([
            'trainer.user',
            'game',
            'timeSlot',
        ]);

        return view(
            'trainer-game-time-slot.show',
            compact('trainerGameTimeSlot')
        );
    }

    /**
     * عرض صفحة تعديل التعيين.
     */
    public function edit(TrainerGameTimeSlot $trainerGameTimeSlot)
{
    $trainerGameTimeSlot->load([
        'trainer.user',
        'game',
        'timeSlot',
    ]);

    $trainers = Staff::query()
        ->where('role', 'trainer')
        ->with('user')
        ->orderBy('id')
        ->get();

    $games = Game::query()
        ->orderBy('name')
        ->get();

    $timeSlots = TimeSlot::query()
        ->with('games')
        ->orderBy('start_time')
        ->get();

    $timeSlotsData = $timeSlots->map(function ($slot) {
        return [
            'id' => $slot->id,
            'name' => $slot->name,
            'start_time' => \Carbon\Carbon::parse($slot->start_time)->format('H:i'),
            'end_time' => \Carbon\Carbon::parse($slot->end_time)->format('H:i'),
            'games' => $slot->games->map(function ($game) {
                return [
                    'id' => $game->id,
                    'name' => $game->name,
                ];
            })->values()->toArray(),
        ];
    })->values()->toArray();

    return view(
        'trainer-game-time-slot.edit',
        compact(
            'trainerGameTimeSlot',
            'trainers',
            'games',
            'timeSlots',
            'timeSlotsData'
        )
    );
}

    /**
     * تحديث التعيين.
     */
    public function update(
        UpdateTrainerGameTimeSlotRequest $request,
        TrainerGameTimeSlot $trainerGameTimeSlot
    ) {
        $this->updateService->update(
            $request->validated(),
            $trainerGameTimeSlot
        );

        return redirect()
            ->route(
                'trainer-game-time-slots.show',
                $trainerGameTimeSlot
            )
            ->with(
                'success',
                'تم تحديث تعيين المدرب بنجاح.'
            );
    }

    /**
     * حذف التعيين.
     */
    public function destroy(
        TrainerGameTimeSlot $trainerGameTimeSlot
    ) {
        $this->deleteService->delete(
            $trainerGameTimeSlot
        );

        return redirect()
            ->route(
                'trainer-game-time-slots.index'
            )
            ->with(
                'success',
                'تم حذف تعيين المدرب بنجاح.'
            );
    }
}