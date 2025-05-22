<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class CreateRsvpRequest extends FormRequest
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
            'invitation_id' => 'required|exists:invitations,id,deleted_at,NULL',
            'invitation_guest_book_id' => 'required|exists:invitation_guest_books,id,deleted_at,NULL',
            'name' => 'required|string|max:40',
            'is_present' => 'required|boolean'
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
