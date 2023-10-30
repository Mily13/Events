<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest{

    public function rules(): array
    {
        return [
            'name' => 'required|max:99',
            'date' => 'required',
            'location' => 'required|max:99',
            'type' => 'required|max:99',
            'description' => 'required|max:400',
            'image' => 'image|max:4096|dimensions:min_width=50,min_height=50,max_width=4000,max_height=4000'
        ];
    }
}
