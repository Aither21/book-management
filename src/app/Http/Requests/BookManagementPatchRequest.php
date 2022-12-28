<?php

namespace App\Http\Requests;

use App\Enums\BookManagementStatusType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookManagementPatchRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        // dd(Rule::enum(BookManagementStatusType::APPLYING_RETURN->value));

        return [
            'status' => ['required', Rule::in([BookManagementStatusType::APPLYING_RETURN->value])],
            'userId' => 'required|integer'
        ];
    }
}
