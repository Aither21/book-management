<?php

namespace App\Http\Requests;

use App\Enums\BookManagementStatusType;
use App\Enums\SortType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookManagementGetListRequest extends FormRequest
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
        return [
            'page' => 'nullable|integer',
            'freeword' => 'nullable|string|max:150',
            'sort' =>  ['required', Rule::in(SortType::values())],
            'status' => ['nullable', Rule::in(BookManagementStatusType::values())]
        ];
    }
}
