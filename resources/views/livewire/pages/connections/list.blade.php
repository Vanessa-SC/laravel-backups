<?php

use App\Models\Connection;

use function Livewire\Volt\{state, rules, computed, on};

$getConnections = fn() =>
$this->connections = Connection::orderByDesc('id')
    ->get()
    ->map(callback: function ($item) {
        // $item->db_password_h = preg_replace_callback('/\b\w+\b/', fn($coincidencias) => str_repeat('*', strlen($coincidencias[0])), $item->db_password);
        $item->db_password_h = str_repeat ('*', strlen ($item->db_password));
        return $item;
    });

state([
    'connections' => $getConnections,
    'selected' => null,
]);

on([
    'connection-saved' => $getConnections,
    'connection-deleted' => $getConnections
]);

$delete = function ($id) {
    Connection::destroy($id);
    $this->dispatch('connection-deleted');
};

$edit = function ($id) {
    $this->selected = Connection::find($id);
    $this->dispatch('edit-connection', $this->selected);
}

?>

<div class="overflow-x-auto">
    <table class="border-collapse table-auto w-full text-sm">
        <thead>
            <tr>
                <th class="border-b border-slate-500 bg-slate-400 px-2 py-3 text-left">Name</th>
                <th class="border-b border-slate-500 bg-slate-400 px-2 py-3 text-left">DB Host</th>
                <th class="border-b border-slate-500 bg-slate-400 px-2 py-3 text-left">DB User</th>
                <th class="border-b border-slate-500 bg-slate-400 px-2 py-3 text-left">DB Password</th>
                <th class="border-b border-slate-500 bg-slate-400 px-2 py-3 text-left">DB Name</th>
                <th class="border-b border-slate-500 bg-slate-400 px-2 py-3 text-center">Options</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-slate-800">
            @forelse ($connections as $connection)
            <tr>
                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $connection->name }}</td>
                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $connection->db_host }}</td>
                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $connection->db_user }}</td>
                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $connection->db_password_h }}</td>
                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $connection->db_name }}</td>
                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400 flex gap-1">
                    <button class="px-5 py-2 rounded bg-blue-600 text-white flex gap-1" wire:click="edit({{ $connection->id }})">
                        <span class="material-icons">edit</span>
                        Edit
                    </button>
                    <button class="px-5 py-2 rounded bg-red-600 text-white flex gap-1" wire:click="delete({{ $connection->id }})">
                        <span class="material-icons">delete</span>
                        Delete
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400" colspan="6">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>