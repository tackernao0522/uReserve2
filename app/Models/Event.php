<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function eventDate(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->start_date)->format('Y年m月d日')
        );
    }

    protected function startTime(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->start_date)->format('H時i分')
        );
    }

    protected function endTime(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->end_date)->format('H時i分')
        );
    }

    protected function editEventDate(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->start_date)->format('Y-m-d')
        );
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'reservations')
            ->withPivot('id', 'number_of_people', 'canceled_date');
    }

    public function scopeUpcomingEvents(Builder $query)
    {
        return $query
            ->select(['events.*'])
            ->leftJoinSub(Reservation::reservedPeople(), 'reservedPeople', function ($join) {
                $join->on('events.id', '=', 'reservedPeople.event_id');
            })
            ->whereDate('start_date', '>=', Carbon::today())
            ->orderBy('start_date', 'ASC');
    }

    public function scopePastEvents(Builder $query)
    {
        return $query
            ->select(['events.*'])
            ->leftJoinSub(Reservation::reservedPeople(), 'reservedPeople', function ($join) {
                $join->on('events.id', '=', 'reservedPeople.event_id');
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->orderBy('start_date', 'DESC');
    }
}
