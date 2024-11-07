<?php

use function Livewire\Volt\{state, rules};
use App\Livewire\Forms\CreateConnectionForm;
use App\Models\Connection;

use function Livewire\Volt\form;

form(CreateConnectionForm::class);

$saveConnection = function () {
    $this->form->store();
    $this->dispatch('connection-created');
    $createConnectionMessage = "Connection created: {$this->form->name}";
    session()->flash('status', $createConnectionMessage);
};

$closeAlert = function () {
    session()->forget('status');
}

?>

<div>
    @if(session('status'))
    <div class="p-3 bg-green-500 mb-5">
        {{session('status')}}
        <x-slot:actions>
            <form wire:submit="closeAlert">
                <button wire:click="logout" type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Dissmiss') }}
                </button>
            </form>

        </x-slot:actions>
    </div>
    @endif
    <form wire:submit="saveConnection">
        <!-- Connection's name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="form.name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
        </div>

        <!-- Database's host -->
        <div>
            <x-input-label for="db_host" :value="__('DB Host')" />
            <x-text-input wire:model="form.db_host" id="db_host" class="block mt-1 w-full" type="text" name="db_host" required autofocus autocomplete="db_host" />
            <x-input-error :messages="$errors->get('form.db_host')" class="mt-2" />
        </div>

        <!-- Database's user -->
        <div>
            <x-input-label for="db_user" :value="__('DB User')" />
            <x-text-input wire:model="form.db_user" id="db_user" class="block mt-1 w-full" type="text" name="db_user" required autofocus autocomplete="db_user" />
            <x-input-error :messages="$errors->get('form.db_user')" class="mt-2" />
        </div>

        <!-- Database's Password -->
        <div class="mt-4">
            <x-input-label for="db_password" :value="__('DB Password')" />
            <x-text-input wire:model="form.db_password" id="db_password" class="block mt-1 w-full"
                type="password"
                name="db_password"
                required autocomplete="db_password" />

            <x-input-error :messages="$errors->get('form.db_password')" class="mt-2" />
        </div>

        <!-- Database's name -->
        <div>
            <x-input-label for="dbname" :value="__('DB Name')" />
            <x-text-input wire:model="form.db_name" id="db_name" class="block mt-1 w-full" type="text" name="db_name" required autofocus autocomplete="db_name" />
            <x-input-error :messages="$errors->get('form.db_name')" class="mt-2" />
        </div>

        <div class="text-right mt-3">
            <button class="bg-gray-800 text-white py-1 px-4 rounded hover:bg-gray-700">Save</button>
        </div>
        
    </form>
    <div>
        @error('name')<span class="text-danger">{{$message}}</span>@enderror
    </div>
</div>