<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest{

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:99',
            'email' => 'required|string|email|unique:users,email|max:99',
            'password' => 'required|string|min:6|confirmed|max:255',
            'phone' => 'required|string|max:99',
            'birthday' => 'required|date',
        ];
    }
}
