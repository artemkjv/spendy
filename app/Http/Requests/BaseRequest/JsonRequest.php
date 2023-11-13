<?php namespace App\Http\Requests\BaseRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class JsonRequest extends FormRequest {

    public function expectsJson()
    {
        return true;
    }

    public function validationData()
    {
        return $this->json()->all();
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors'      => $validator->errors()
        ])->setStatusCode(422));
    }

}
