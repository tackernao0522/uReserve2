<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Services\EventService;
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
        $check = EventService::checkEventDuplication(
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );

        if ($check) {
            // 存在したら
            session()->flash('status', 'この時間帯は既に他の予約が存在します。');

            return redirect()->back();
        }

        $dateTimeData = EventService::joinDateAndTime(
            $request->input('event_date'),
            $request->input('start_time'),
            $request->input('end_time')
        );

        Event::create([
            'name' => $request['event_name'],
            'information' => $request['information'],
            'start_date' => $dateTimeData['start_date'],
            'end_date' => $dateTimeData['end_date'],
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible'],
        ]);

        session()->flash('status', '登録OKです。');

        return to_route('events.index');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        $eventDate = $event->eventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;

        return view(
            'manager.events.show',
            compact(
                'event',
                'eventDate',
                'startTime',
                'endTime'
            )
        );
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $eventDate = $event->eventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;

        return view(
            'manager.events.edit',
            compact(
                'event',
                'eventDate',
                'startTime',
                'endTime'
            )
        );
    }

    public function update(Request $request, $id)
    {
        
    }
}
