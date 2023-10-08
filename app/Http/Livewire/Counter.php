<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;
    public $name = '';

    public function mount()
    {
        $this->name = 'mount'; // 初期値としてinput枠に'mount'という文字が入る
    }

    public function updated() // 文字を変更すると'updateというもじに更新される リアルタイムバリデーション等に使える
    {
        $this->name = 'updated';
    }

    public function mouseOver()
    {
        $this->name = 'mouseover';
    }

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
