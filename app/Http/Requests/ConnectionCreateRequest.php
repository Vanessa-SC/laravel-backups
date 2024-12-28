<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConnectionCreateRequest extends FormRequest
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
            'name' => 'required',
            'db_host' => 'required',
            'db_user' => 'required',
            'db_password' => 'required',
            'db_name' => 'required',
            'db_port' => 'number|nullable',
            'cron_expression' => "required|string|regex:'/^(\*|\d+|\d+,\d+|\d+-\d+|\*\/\d+)(\s+(\*|\d+|\d+,\d+|\d+-\d+|\*\/\d+)){4,5}$/'",
        ];
    }
}
