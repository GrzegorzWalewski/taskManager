<div class="border border-blue-200 p-2 rounded">
    <div class="grid grid-cols-2 gap-4 border-b border-blue-200">
        <h2>{{ __($title) }}</h2>
        <button wire:click="clearNewForm" @click="showNewForm=true, newStatus='{{ $status }}'"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            type="button">
            {{ __("Add new task") }}
        </button>
    </div>

    @foreach ($tasks as $task)
        <x-task wire:key="task-{{ $task->id }}" :task="$task"></x-task>
    @endforeach
</div>