<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function detail($id)
    {
        $event = Event::findOrFail($id);

        $reservedPeople = Reservation::reservedPeople()
            ->having('event_id', $event->id)
            ->first();

        if (!is_null($reservedPeople)) {
            $reservablePeople =
                $event->max_people - $reservedPeople->number_of_people;
        } else {
            $reservablePeople = $event->max_people;
        }

        return view('event-detail', compact('event', 'reservablePeople'));
    }
}
