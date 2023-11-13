<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'account' => 'required|string|max:255',
            'team' => 'required|string|max:255',
            'team_position' => 'required|string|max:255',
            'traffic_source' => 'required|string|max:255',
            'traffic_vertical' => 'required|string|max:255',
        ];
    }
}
