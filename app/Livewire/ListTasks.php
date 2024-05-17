<?php

namespace App\Livewire;

use Livewire\Component;

class ListTasks extends Component
{
    public $todo, $inprogress, $completed;

    public function render()
    {
        $this->todo = auth()->user()->tasks()->where('status', 0)->get();
        $this->inprogress = auth()->user()->tasks()->where('status', 1)->get();
        $this->completed = auth()->user()->tasks()->where('status', 2)->get();

        return view('livewire.list-tasks');
    }
}
