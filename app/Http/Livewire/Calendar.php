<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use Carbon\CarbonImmutable;
use Livewire\Component;

class Calendar extends Component
{
    public $currentDate; // 現在の日付
    public $day;
    public $currentWeek; // 一週間分
    public $sevenDaysLater;
    public $events;

    public function mount() // 初期値の状態
    {
        $this->currentDate = CarbonImmutable::today();
        $this->sevenDaysLater = $this->currentDate->addDays(7);
        $this->currentWeek = [];

        $this->events = EventService::getWeekEvents(
            $this->currentDate->format('Y-m-d'),
            $this->sevenDaysLater->format('Y-m-d')
        );

        for ($i = 0; $i < 7; $i++) {
            $this->day = CarbonImmutable::today()
                ->addDays($i)
                ->format('m月d日');

            array_push($this->currentWeek, $this->day);
        }
    }

    public function getDate($date)
    {
        $this->currentDate = $date; // 文字列
        $this->currentWeek = [];
        $this->sevenDaysLater = CarbonImmutable::parse($this->currentDate)->addDays(7);

        $this->events = EventService::getWeekEvents(
            $this->currentDate,
            $this->sevenDaysLater->format('Y-m-d')
        );

        for ($i = 0; $i < 7; $i++) {
            $this->day = CarbonImmutable::parse($this->currentDate)
                ->addDays($i)
                ->format('m月d日'); // parseでCarbonインスタンスに型変換 日付を計算

            array_push($this->currentWeek, $this->day);
        }
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
