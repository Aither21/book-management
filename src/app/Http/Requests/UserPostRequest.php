<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserPostRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                Rule::unique(User::class),
            ],
            'company' => ['required', 'string', 'max:10']
        ];
    }

    public function toUser(): User
    {
        $requestUser = $this->validated();
        $user = new User();
        $user->name = $requestUser['name'];
        $user->email = $requestUser['email'];
        $user->company = $requestUser['company'];
        return $user;
    }
}
