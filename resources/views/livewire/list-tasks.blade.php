<div x-data="{showSidenav:false}">
    <div class="grid grid-cols-3 gap-4">
        <x-tasks-column :tasks="$todo" :title="'To do'"></x-list-tasks>
        <x-tasks-column :tasks="$inprogress" :title="'In Progress'"></x-list-tasks>
        <x-tasks-column :tasks="$completed" :title="'Done'"></x-list-tasks>
    </div>
    <x-drawer></x-drawer>
</div>