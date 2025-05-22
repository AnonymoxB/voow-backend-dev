<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class UpdateMusicInvitationRequest extends FormRequest
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
        return [
            'invitation_id' => 'required|exists:invitations,id',
            'music_id' => 'required',
            'music_active' => 'required|boolean'
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
