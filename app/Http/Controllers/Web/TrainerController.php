<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trainer\StoreTrainerRequest;
use App\Http\Requests\Trainer\UpdateTrainerRequest;
use App\Models\Staff;
use App\Services\Trainer\TrainerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class TrainerController extends Controller
{
    public function __construct(
        private readonly TrainerService $trainerService
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Staff::class);

        $trainers = $this->trainerService->getTrainers(
            $request->input('search')
        );

        return view(
            'trainers.index',
            compact('trainers')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        Gate::authorize('create', Staff::class);

        return view('trainers.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(
        StoreTrainerRequest $request
    ): RedirectResponse {

        Gate::authorize('create', Staff::class);

        $this->trainerService->createTrainer(
            $request->validated()
        );

        return redirect()
            ->route('trainers.index')
            ->with(
                'success',
                'تم إنشاء حساب المدرب بنجاح.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(Staff $trainer): View
    {
        abort_unless(
            $trainer->role === 'trainer',
            404
        );

        Gate::authorize(
            'view',
            $trainer
        );

        return view(
            'trainers.show',
            compact('trainer')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(Staff $trainer): View
    {
        abort_unless(
            $trainer->role === 'trainer',
            404
        );

        Gate::authorize(
            'update',
            $trainer
        );

        return view(
            'trainers.edit',
            compact('trainer')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        UpdateTrainerRequest $request,
        Staff $trainer
    ): RedirectResponse {

        abort_unless(
            $trainer->role === 'trainer',
            404
        );

        Gate::authorize(
            'update',
            $trainer
        );

        $this->trainerService->updateTrainer(
            $trainer,
            $request->validated()
        );

        return redirect()
            ->route('trainers.index')
            ->with(
                'success',
                'تم تعديل بيانات المدرب بنجاح.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Staff $trainer
    ): RedirectResponse {

        abort_unless(
            $trainer->role === 'trainer',
            404
        );

        Gate::authorize(
            'delete',
            $trainer
        );

        $this->trainerService->deleteTrainer(
            $trainer
        );

        return redirect()
            ->route('trainers.index')
            ->with(
                'success',
                'تم حذف المدرب بنجاح.'
            );
    }
}