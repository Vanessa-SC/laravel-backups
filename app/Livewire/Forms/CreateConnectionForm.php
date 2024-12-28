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
    
    #[Validate('required|integer')]
    public string $db_port = '';

    // #[Validate(required|string|regex:'/^(\*|\d+|\d+,\d+|\d+-\d+|\*\/\d+)(\s+(\*|\d+|\d+,\d+|\d+-\d+|\*\/\d+)){4,5}$/'")]
    // public string $cron_expression = '*';
    

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
