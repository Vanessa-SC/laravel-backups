<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConnectionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return boolval(Auth::user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'db_host' => 'required|string|max:255',
            'db_user' => 'required|string|max:255',
            'db_password' => 'required|string|max:255',
            'db_name' => 'required|string|max:255',
            'db_port' => 'number|nullable',
            'cron_expression' => "required|string|regex:'/^(\*|\d+|\d+,\d+|\d+-\d+|\*\/\d+)(\s+(\*|\d+|\d+,\d+|\d+-\d+|\*\/\d+)){4,5}$/'",
        ];
    }
}
