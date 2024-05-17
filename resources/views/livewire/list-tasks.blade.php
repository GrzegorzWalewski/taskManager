<div x-data="{showNewForm:false, showEditForm:false, newStatus: @entangle('status')}">
    <x-action-message on="success" class="mb-4">{{ session('message') }}</x-action-message>
    <div class="grid grid-cols-3 gap-4">
        <x-tasks-column :tasks="$todo" :title="'To do'" :status="0"></x-list-tasks>
        <x-tasks-column :tasks="$inprogress" :title="'In Progress'" :status="1"></x-list-tasks>
        <x-tasks-column :tasks="$completed" :title="'Done'" :status="2"></x-list-tasks>
    </div>
    <x-new-drawer></x-new-drawer>
    <x-edit-task-drawer></x-edit-task-drawer>
</div>