<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function reserve(Request $request)
    {
        $event = Event::findOrFail($request->id);

        $reservedPeople = Reservation::reservedPeople()
            ->having('event_id', $event->id)
            ->first();

        if (is_null($request->reserved_people)) {
            session()->flash('status', '満了なので予約はできません。');

            return to_route('dashboard');
        } elseif (
            is_null($reservedPeople)
            ||
            $event->max_people
            >=
            $reservedPeople->number_of_people + $request->reserved_people
        ) {
            Reservation::create([
                'user_id' => Auth::id(),
                'event_id' => $request->id,
                'number_of_people' => $request->reserved_people,
            ]);

            session()->flash('status', '予約が完了しました。');

            return to_route('dashboard');
        } else {
            session()->flash('status', 'この人数は予約できません');

            return to_route('dashboard');
        }
    }
}
