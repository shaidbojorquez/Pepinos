<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use App\Exceptions\CustomValidationException;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
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
        switch ($this->method()) 
        {
            case 'GET':
            case 'DELETE':
            {
               
            }
            case 'POST':
            {
                return [
                    'data.attributes.name' => 'max:100|required',
                    'data.attributes.price' => 'required|numeric|gt:0'
                ];
            }
            case 'PUT': 
            case 'PATCH':
            {
                return[
                    'data.attributes.price' => 'required|numeric|gt:0'
                ];
            }
            
               
            
            default:
                # code...
                break;
        }
    }


    protected function failedValidation(Validator $validator)
    {
        throw new CustomValidationException($validator);
    }
}

