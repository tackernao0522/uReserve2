<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $events = DB::table('events')->orderBy('start_date', 'ASC')->paginate(10);

        return view('manager.events.index', compact('events'));
    }

    public function create()
    {
        return view('manager.events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $start = $request['event_date'] . ' ' . $request['start_time'];
        $startDate = Carbon::createFromFormat('Y-m-d H:i', $start);

        $end = $request['event_date'] . ' ' . $request['end_time'];
        $endDate = Carbon::createFromFormat('Y-m-d H:i', $end);

        Event::create([
            'name' => $request['event_name'],
            'information' => $request['information'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible'],
        ]);

        session()->flash('status', '登録OKです。');

        return to_route('events.index');
    }
}
