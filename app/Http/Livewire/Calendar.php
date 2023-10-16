<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class Calendar extends Component
{
    public $currentDate; // 現在の日付
    public $day;
    public $currentWeek; // 一週間分

    public function mount() // 初期値の状態
    {
        $this->currentDate = Carbon::today();
        $this->currentWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $this->day = Carbon::today()
                ->addDays($i)
                ->format('m月d日');

            array_push($this->currentWeek, $this->day);
        }
        // dd($this->currentWeek);
    }

    public function getDate($date)
    {
        $this->currentDate = $date; // 文字列
        $this->currentWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $this->day = Carbon::parse($this->currentDate)
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