<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if(request()->isMethod('PUT') || request()->isMethod('PATCH')) {
            return [
                'orgnization_id' => ['nullable', 'integer' , 'exists:users,id'],
                'country_id' => ['nullable', 'integer' , 'exists:countries,id'],
                'city_id' => ['nullable', 'integer' , 'exists:cities,id'],
                'zone_id' => ['nullable', 'integer' , 'exists:zones,id'],
                'name' => ['nullable', 'string', 'max:255'],
                'date' => ['nullable', 'date'],
                'start_time' => ['nullable'],
                'end_time' => ['nullable'],
                'number_of_volunteers' => ['nullable', 'integer','min:1'],
                'number_of_organizers' => ['nullable', 'integer','min:1'],
                'location' => ['nullable', 'string'],
                'google_maps_location' => ['nullable', 'string'],
                'description' => ['nullable', 'string'],
                'image' => ['nullable'],
                'status'=> ['nullable', 'in:active,inactive'],
                'benfit.*'=> ['nullable', 'array'],
                'benfit.*.benfit' => ['nullable', 'string'],
                'benfit.*.status' => ['nullable', 'in:active,inactive'],
                'requirment.*'=> ['nullable', 'array'],
                'requirment.*.requirment' => ['nullable', 'string'],
                'requirment.*.status' => ['nullable', 'in:active,inactive'],
            ];
        }
        return [
            'orgnization_id' => ['nullable', 'integer' , 'exists:users,id'],
            'country_id' => ['required', 'integer' , 'exists:countries,id'],
            'city_id' => ['required', 'integer' , 'exists:cities,id'],
            'zone_id' => ['required', 'integer' , 'exists:zones,id'],
            'name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'number_of_volunteers' => ['required', 'integer','min:1'],
            'number_of_organizers' => ['required', 'integer','min:1'],
            'location' => ['required', 'string'],
            'google_maps_location' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image' => ['nullable'],
            'status'=> ['required', 'in:active,inactive'],
            'benfit.*'=> ['required', 'array'],
            'benfit.*.benfit' => ['required', 'string'],
            'benfit.*.status' => ['required', 'in:active,inactive'],
            'requirment.*'=> ['required', 'array'],
            'requirment.*.requirment' => ['required', 'string'],
            'requirment.*.status' => ['required', 'in:active,inactive'],
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ],400),);
    }
}
