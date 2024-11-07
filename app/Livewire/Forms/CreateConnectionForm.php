<?php

namespace App\Livewire\Forms;

use App\Models\Connection;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Validation\ValidationException;

class CreateConnectionForm extends Form
{
    #[Validate('required|string')]
    public string $name = '';

    #[Validate('required|string')]
    public string $db_name = '';

    #[Validate('required|string')]
    public string $db_host = '';

    #[Validate('required|string')]
    public string $db_user = '';

    #[Validate('required|string')]
    public string $db_password = '';
    

    public function store(){
        $this->validate();
        Connection::create($this->all());
        $this->reset();
    }

    public function update(){
        $this->validate();
        $item = Connection::first();
        $item->fill($this->all());
        $item->save();
        $this->reset();
    }
}
