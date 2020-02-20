<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(
            request()->isMethod('POST')
        ){
            return [
                'name' => 'required|unique:races|max:255',
                'date' => 'required',
                'prize' => 'required',
                'location' => 'required'
            ];
        }

        if(
            request()->isMethod('PATCH')
        ){
            return [
                'name' => 'required|max:255',
                'date' => 'required',
                'prize' => 'required',
                'location' => 'required'
            ];
        }
    }
}
