<?php

namespace App\Livewire\Forms;

use App\Models\Configuration;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateConfigForm extends Form
{
    #[Validate('required|string')]
    public string $dir_path = '';

    #[Validate('required|string')]
    public string $dump_path = '';

    #[Validate('string')]
    public string $compressor_path = '';

    #[Validate('string')]
    public string $file_extension = '';

    public function update($id){
        $this->validate();
        $item = Configuration::findOrNew($id);
        $item->fill($this->all());
        $item->save();
        $this->reset();
    }
}
