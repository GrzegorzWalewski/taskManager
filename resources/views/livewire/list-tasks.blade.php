<div x-data="{showSidenav:false, newStatus: @entangle('status')}">
    <div class="grid grid-cols-3 gap-4">
        <x-tasks-column :tasks="$todo" :title="'To do'" :status="0"></x-list-tasks>
        <x-tasks-column :tasks="$inprogress" :title="'In Progress'" :status="1"></x-list-tasks>
        <x-tasks-column :tasks="$completed" :title="'Done'" :status="2"></x-list-tasks>
    </div>
    <x-drawer></x-drawer>
</div>