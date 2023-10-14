<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('event_id');
        // dd($reservedPeople);

        $events = DB::table('events')
            ->leftJoinSub($reservedPeople, 'reservedPeople', function ($join) {
                $join->on('events.id', '=', 'reservedPeople.event_id');
            })
            ->whereDate('start_date', '>=', $today)
            ->orderBy('start_date', 'ASC')->paginate(10);

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

        $startDate = EventService::joinDateAndTime(
            $request['event_date'],
            $request['start_time']
        );
        $endDate = EventService::joinDateAndTime(
            $request['event_date'],
            $request['end_time']
        );

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

    public function show($id)
    {
        $event = Event::findOrFail($id);
        $users = $event->users;

        $reservations = [];

        foreach ($users as $user) {
            $reservedInfo = [
                'name' => $user->name,
                'number_of_people' => $user->pivot->number_of_people,
                'canceled_date' => $user->pivot->canceled_date,
            ];

            array_push($reservations, $reservedInfo);
        }

        $eventDate = $event->editEventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;

        return view(
            'manager.events.show',
            compact(
                'event',
                'users',
                'reservations',
                'eventDate',
                'startTime',
                'endTime'
            )
        );
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        if ($event->eventDate >= Carbon::today()->format('Y年m月d日')) {
            // $event = Event::findOrFail($event->id);
            $eventDate = $event->editEventDate;
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
        } else {
            session()->flash('status', '過去のイベントは更新できません。');
            return to_route('events.index');
        }
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $check = EventService::countEventDuplication(
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );

        if ($check > 1) {
            $event = Event::findOrFail($id);
            $eventDate = $event->editEventDate;
            $startTime = $event->startTime;
            $endTime = $event->endTime;

            session()->flash('status', 'この時間帯は既に他の予約が存在します。');

            return to_route('events.edit', compact(
                'event',
                'eventDate',
                'startTime',
                'endTime'
            ));
        }

        $startDate = EventService::joinDateAndTime(
            $request['event_date'],
            $request['start_time']
        );
        $endDate = EventService::joinDateAndTime(
            $request['event_date'],
            $request['end_time']
        );

        $event = Event::findOrFail($id);
        $event->name = $request->event_name;
        $event->information = $request->information;
        $event->start_date = $startDate;
        $event->end_date = $endDate;
        $event->max_people = $request->max_people;
        $event->is_visible = $request->is_visible;
        $event->save();

        session()->flash('status', '更新しました。');

        return to_route('events.index');
    }

    public function past()
    {
        $today = Carbon::today();

        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('event_id');

        $events = DB::table('events')
            ->leftJoinSub($reservedPeople, 'reservedPeople', function ($join) {
                $join->on('events.id', '=', 'reservedPeople.event_id');
            })->whereDate('start_date', '<', $today)
            ->orderBy('start_date', 'DESC')
            ->paginate(10);

        return view('manager.events.past', compact('events'));
    }
}
