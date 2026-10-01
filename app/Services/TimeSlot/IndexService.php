<?php

namespace App\Services\TimeSlot;

use App\Models\TimeSlot;
use Illuminate\Http\Request;

class IndexService
{
    public function index(Request $request)
    {
        $timeslots = TimeSlot::paginate(7);

        return view('timeslot.index', compact('timeslots'));
    }
}
