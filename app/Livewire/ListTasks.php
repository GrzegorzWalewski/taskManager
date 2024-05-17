<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;

class ListTasks extends Component
{
    public $todo, $inprogress, $completed;

    #[Validate('required', 'string', 'max:255')] 
    public $title;

    #[Validate('required', 'integer', 'in:0,1,2')]
    public $status;

    #[Validate('required', 'string', 'max:255')]
    public $description;

    public function addTask()
    {
        $this->validate();

        auth()->user()->tasks()->create([
            'title' => $this->title,
            'status' => $this->status,
            'description' => $this->description
        ]);

        $this->reset();
    }

    public function render()
    {
        $this->todo = auth()->user()->tasks()->where('status', 0)->get();
        $this->inprogress = auth()->user()->tasks()->where('status', 1)->get();
        $this->completed = auth()->user()->tasks()->where('status', 2)->get();

        return view('livewire.list-tasks');
    }
}
