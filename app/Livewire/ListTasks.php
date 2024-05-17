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

    public $taskId;

    public function addTask()
    {
        $this->validate();

        auth()->user()->tasks()->create([
            'title' => $this->title,
            'status' => $this->status,
            'description' => $this->description
        ]);

        session()->flash('message', 'Task added successfully');
        $this->dispatch('success');

        $this->reset();
    }

    public function deleteTask($id)
    {
        auth()->user()->tasks()->find($id)->delete();
        session()->flash('message', 'Task deleted successfully');
        $this->dispatch('success');
    }

    public function editTask($id)
    {
        $task = auth()->user()->tasks()->find($id);

        $this->title = $task->title;
        $this->status = $task->status;
        $this->description = $task->description;
        $this->taskId = $task->id;
    }

    public function updateTask()
    {
        $this->validate();

        auth()->user()->tasks()->find($this->taskId)->update([
            'title' => $this->title,
            'status' => $this->status,
            'description' => $this->description
        ]);

        $this->reset();
        session()->flash('message', 'Task updated successfully');
        $this->dispatch('success');
    }

    public function clearNewForm()
    {
        $this->title = null;
        $this->description = null;
        $this->taskId = null;
    }

    public function render()
    {
        $this->todo = auth()->user()->tasks()->where('status', 0)->get();
        $this->inprogress = auth()->user()->tasks()->where('status', 1)->get();
        $this->completed = auth()->user()->tasks()->where('status', 2)->get();

        return view('livewire.list-tasks');
    }
}
