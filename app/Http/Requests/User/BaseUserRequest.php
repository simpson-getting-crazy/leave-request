<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BaseUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'unique:users,email,'.request()->route()->getName() == 'admin.user.update'
                    ? $this->id
                    : ''
            ],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:employee,manager'],
        ];
    }

    /**
     * Get the attribute names for the defined validation rules.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Prepares the request data for validation when updating a user.
     * If the request is for the 'admin.user.update' route, it merges the existing user's password into the request
     */
    public function prepareForValidation(): void
    {
        if (request()->route()->getName() == 'admin.user.update') {
            $user = User::query()->where('id', $this->id)->first();

            $this->merge([
                'password' => $this->password ?? $user->password,
            ]);
        }
    }
}
