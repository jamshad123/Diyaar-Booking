<?php

namespace App\Http\Livewire\General;

use Livewire\Component;

class Clock extends Component
{
    public function mount()
    {
        $this->clockState = true;
    }

    public function clockState()
    {

        $this->clockState = $this->clockState ? false : true;
    }

    public function render()
    {
        return view('livewire.general.clock');
    }
}
