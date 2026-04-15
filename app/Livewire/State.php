<?php

namespace App\Livewire;

use App\Models\State as ModelsState;
use Livewire\Component;
use Livewire\WithPagination;

class State extends Component
{
    use WithPagination;

    public function render()
    {
        $states = ModelsState::paginate(10);
        return view('livewire.state')->with('states', $states);
    }
}
