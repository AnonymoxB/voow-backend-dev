<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
class InvitationSettingUpdate extends FormRequest
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
        $userId = auth()->user()->id;

        return [
            'invitation_id' => 'required|exists:invitations,id',
            'invitation_link' => 'nullable|regex:/^[a-z0-9-]+$/',
            'title' => 'string|nullable',
            'description' => 'string|nullable',
            'event_date' => 'string|nullable',
            'event_time' => 'string|nullable',
            'address' => 'string|nullable',
            'time_zone' => 'string|nullable',
            'address' => 'string|nullable',
            'lang' => 'in:ID,EN|required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response =  ResponseBuilder::asError(400)
            ->withHttpCode(400)
            ->withMessage("Request Failed")
            ->withData($validator->errors()->toArray())
            ->build();


        throw (new ValidationException($validator, $response));
    }
}
