<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        if (!isset($input['company'])) {
            $input['company'] = 'KITU'; // Komazawa IT Union
        }

        $user = new User();
        $user->fill([
            'name' => $input['name'],
            'email' => $input['email'],
            'company' => $input['company'],
            'password' => Hash::make($input['password'])
        ])->save();
        return $user;
    }
}
