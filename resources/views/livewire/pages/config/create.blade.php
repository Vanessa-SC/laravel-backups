<?php

use function Livewire\Volt\{state, rules, computed, on};
use App\Livewire\Forms\UpdateConfigForm;
use App\Models\Configuration;

use function Livewire\Volt\form;

$getConfig = function(){
    $config = Configuration::first();
    if($config) {
        $this->form->fill($config);
    }
    return $config;
};

form(UpdateConfigForm::class);
state(['config' => $getConfig, 'show' => false]);
on(['config-saved' => $getConfig]);

$saveConfig = function () {
    $this->form->update();
    $this->dispatch('connection-saved');
    $this->show = false;
    session()->flash('status', "Configuration updated");
};

$toggleShow = fn() => $this->show = !$this->show;

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
    <h1 class="font-bold text-lg">Configuration</h1>
        <form wire:submit="saveConfig">

            <div class="flex flex-row flex-wrap gap-y-2">

                <!-- Path directory -->
                <div class="basis-full">
                    <x-input-label for="dir_path" :value="__('Main path directory to save backups')" />
                    <x-text-input wire:model="form.dir_path" id="dir_path" class="block mt-1 w-full" type="text"
                        name="dir_path"
                        required autofocus
                        placeholder="Path to save in local disk the final backup file"
                        autocomplete="form.dir_path" />
                    <x-input-error :messages="$errors->get('form.dir_path')" class="mt-2" />
                </div>

                <!-- Path to dump command -->
                <div class="basis-full">
                    <x-input-label for="dump_path" :value="__('Dump command path')" />
                    <x-text-input wire:model="form.dump_path" id="dump_path" class="block mt-1 w-full" type="text"
                        name="dump_path"
                        required autofocus
                        placeholder="Path to mysqldump or mariadb-dump command"
                        autocomplete="form.dump_path" />
                    <x-input-error :messages="$errors->get('form.dump_path')" class="mt-2" />
                </div>

                <!-- Path to compressor command -->
                <div class="basis-full">
                    <x-input-label for="compressor_path" :value="__('Compressor path')" />
                    <x-text-input wire:model="form.compressor_path" id="compressor_path" class="block mt-1 w-full" type="text"
                        name="compressor_path"
                        required autofocus
                        placeholder="Path where the compressor command is located"
                        autocomplete="form.compressor_path" />
                    <x-input-error :messages="$errors->get('form.compressor_path')" class="mt-2" />
                </div>

                <!-- Extension for compressed files -->
                <div class="basis-full">
                    <x-input-label for="file_extension" :value="__('File extension')" />
                    <x-text-input wire:model="form.file_extension" id="file_extension" class="block mt-1 w-full" type="text"
                        name="file_extension"
                        required autofocus
                        placeholder="Extension for backup file after being compressed"
                        autocomplete="form.file_extension" />
                    <x-input-error :messages="$errors->get('form.file_extension')" class="mt-2" />
                </div>

            </div>

            <div class="mt-3 inline-flex gap-2 text-end">
                <button type="button" wire:click="toggleShow"  class="basis-3/12 px-5 py-2 ml-auto rounded bg-slate-500 hover:bg-slate-700 text-white flex gap-1 ml-auto justify-center">
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
        <button class="bg-slate-600 px-5 hover:bg-slate-400 py-2 text-white rounded-md" wire:click="toggleShow" type="button">
        <span class="material-icons">settings</span>
            Edit config
        </button>    
    </div>
    @endif
    <div>
        @error('name')<span class="text-danger">{{$message}}</span>@enderror
    </div>
</div>