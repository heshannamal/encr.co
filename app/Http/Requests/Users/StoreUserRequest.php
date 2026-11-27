<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('add users') ?? false;
    }

    public function rules(): array
    {
        return [
            'new_name' => ['required', 'string', 'max:255'],
            'new_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'new_password' => ['required', 'string', 'min:5', 'max:72'],
            'new_confirm_password' => ['required', 'same:new_password'],
            'new_user_role_id' => ['required', 'array', 'min:1'],
            'new_user_role_id.*' => ['required', 'integer', 'distinct', Rule::exists('roles', 'id')->where('active', 1)->where('guard_name', 'web')],
            'new_user_group_id' => ['required', 'integer', 'exists:user_groups,id'],
            'new_profile_pic' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ];
    }
}
