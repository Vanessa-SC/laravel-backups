<?php

use function Livewire\Volt\{state, rules, computed, on};
use App\Livewire\Forms\CreateConnectionForm;

use function Livewire\Volt\form;

form(CreateConnectionForm::class);

state(['id' => null, 'show' => false]);

$fillForm = function ($data = null) {
    $this->show = true;
    if($data){
        $this->form->fill($data);
        $this->id = $data['id'];
    } else {
        $this->form->reset();
        $this->id = null;
    }
};

on([
    'edit-connection' => $fillForm,
]);

$toggleShow = fn() => $this->show = !$this->show;


$saveConnection = function () {
    if ($this->id) {
        $message = "Connection updated: {$this->form->name}";
        $this->form->update($this->id);
        $this->id = null;
    } else {
        $message = "Connection created: {$this->form->name}";
        $this->form->store();
    }

    $this->dispatch('connection-saved');
    session()->flash('status', $message);
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

    @if($show)
    <h1 class="font-bold text-lg">{{ $id ? 'Edit' : 'New' }} Connection</h1>
    <form wire:submit="saveConnection">

        <div class="flex flex-row flex-wrap gap-y-2">

            <!-- Connection's name -->
            <div class="basis-full">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input wire:model="form.name" id="name" class="block mt-1 w-full" type="text"
                    name="name"
                    required autofocus
                    placeholder="Name to identify the connection"
                    autocomplete="name" />
                <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
            </div>

            <!-- Database's host -->
            <div class="basis-full lg:basis-1/2 md:basis-1/4 px-2">
                <x-input-label for="db_host" :value="__('DB Host')" />
                <x-text-input wire:model="form.db_host" id="db_host" class="block mt-1 w-full" type="text"
                    name="db_host"
                    required autofocus
                    autocomplete="db_host"
                    placeholder="Remote IP address or domain" />
                <x-input-error :messages="$errors->get('form.db_host')" class="mt-2" />
            </div>

            <!-- Database's port -->
            <div class="basis-full lg:basis-1/2 md:basis-1/4 px-2">
                <x-input-label for="db_port" :value="__('DB Port')" />
                <x-text-input wire:model="form.db_port" id="db_port" class="block mt-1 w-full" type="number"
                    name="db_port"
                    required autofocus
                    autocomplete="db_port"
                    placeholder="Remote IP address or domain" />
                <x-input-error :messages="$errors->get('form.db_port')" class="mt-2" />
            </div>

            <!-- Database's user -->
            <div class="basis-full lg:basis-1/2 md:basis-1/4 px-2">
                <x-input-label for="db_user" :value="__('DB User')" />
                <x-text-input wire:model="form.db_user" id="db_user" class="block mt-1 w-full" type="text" name="db_user" required autofocus autocomplete="db_user" placeholder="Database's user" />
                <x-input-error :messages="$errors->get('form.db_user')" class="mt-2" />
            </div>

            <!-- Database's Password -->
            <div class="basis-full lg:basis-1/2 md:basis-1/4 px-2">
                <x-input-label for="db_password" :value="__('DB Password')" />
                <x-text-input wire:model="form.db_password" id="db_password" class="block mt-1 w-full"
                    type="password"
                    name="db_password"
                    placeholder="Database's password"
                    required autocomplete="db_password" />

                <x-input-error :messages="$errors->get('form.db_password')" class="mt-2" />
            </div>

            <!-- Database's name -->
            <div class="basis-full lg:basis-1/2 md:basis-1/4 px-2">
                <x-input-label for="dbname" :value="__('DB Name')" />
                <x-text-input wire:model="form.db_name" id="db_name" class="block mt-1 w-full" type="text"
                    name="db_name"
                    placeholder="Database's name"
                    autocomplete="db_name"
                    required autofocus />
                <x-input-error :messages="$errors->get('form.db_name')" class="mt-2" />
            </div>

            <!-- Cron expression -->
            <div class="basis-full lg:basis-1/2 md:basis-1/4 px-2">
                <x-input-label for="cron_expression" :value="__('Cron expression')" />
                <x-text-input wire:model="form.cron_expression" id="cron_expression" class="block mt-1 w-full" type="text"
                    name="cron_expression"
                    placeholder="Cron expression"
                    autocomplete="cron_expression"
                    required autofocus />
                <x-input-error :messages="$errors->get('form.cron_expression')" class="mt-2" />
            </div>

        </div>

        <div class="mt-3 inline-flex gap-2 text-end">
            <button type="button" wire:click="toggleShow" class="basis-3/12 px-5 py-2 ml-auto rounded bg-slate-500 hover:bg-slate-700 text-white flex gap-1 ml-auto justify-center">
                <span class="material-icons">close</span>
                Cancel
            </button>
            <button class="basis-3/12 px-5 py-2 rounded bg-indigo-500 hover:bg-indigo-700 text-white flex gap-1 ml-auto justify-center">
                <span class="material-icons">save</span>
                Save
            </button>
        </div>

    </form>
    @else
    <div class="text-right">
        <button class="bg-blue-600 px-5 hover:bg-blue-400 py-2 text-white rounded-md" wire:click="fillForm" type="button">
            <span class="material-icons">add</span>
            new connection
        </button>
    </div>
    @endif
    <div>
        @error('name')<span class="text-danger">{{$message}}</span>@enderror
    </div>
</div>