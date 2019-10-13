<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;

class CustomValidationException extends Exception
{
    protected $validator;

    protected $code = 422;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function render()
    {
        // return a json with desired format
        return response()->json([
            "errors" => [
                json_decode(json_encode([
                    "code" => "ERROR-1",
                    "title" => "Unprocessable Entity"
                ]))  
            ]
            // "error" => "form validation error",
            // "message" => $this->validator->errors()->first()
        ], $this->code);
    }

    
}
