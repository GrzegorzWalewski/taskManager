<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Task;

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
        if (auth()->user()->cannot('create', Task::class)) {
            session()->flash('message', 'You do not have permission to create tasks');
            $this->dispatch('newMessage');
            return;
        }

        $this->validate();

        auth()->user()->tasks()->create([
            'title' => $this->title,
            'status' => $this->status,
            'description' => $this->description
        ]);

        session()->flash('message', 'Task added successfully');
        $this->dispatch('newMessage');

        $this->reset();
    }

    public function deleteTask($id)
    {
        if (auth()->user()->cannot('delete', Task::find($id))) {
            session()->flash('message', 'You do not have permission to delete this task');
            $this->dispatch('newMessage');
            return;
        }

        auth()->user()->tasks()->find($id)->delete();
        session()->flash('message', 'Task deleted successfully');
        $this->dispatch('newMessage');
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
        if (auth()->user()->cannot('update', Task::find($this->taskId))) {
            session()->flash('message', 'You do not have permission to update this task');
            $this->dispatch('newMessage');
            return;
        }

        $this->validate();

        auth()->user()->tasks()->find($this->taskId)->update([
            'title' => $this->title,
            'status' => $this->status,
            'description' => $this->description
        ]);

        $this->reset();
        session()->flash('message', 'Task updated successfully');
        $this->dispatch('newMessage');
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
