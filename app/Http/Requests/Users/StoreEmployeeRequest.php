<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('add users') ?? false;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'login_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:5', 'max:72', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
            'user_roles' => ['nullable', 'array'],
            'user_roles.*' => ['integer', 'distinct', Rule::exists('roles', 'id')->where('active', 1)->where('guard_name', 'web')],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'leave_group_id' => ['nullable', 'integer', Rule::exists('leave_groups', 'id')->where('active', 1)],
            'languages' => ['nullable', 'array'],
            'languages.*' => ['string', 'max:100'],
            'dob' => ['nullable', 'date'],
            'joined_date' => ['nullable', 'date'],
            'private_email' => ['nullable', 'email', 'max:255'],
        ];
    }
}
