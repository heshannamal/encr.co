<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('edit users') ?? false;
    }

    public function rules(): array
    {
        $changeLogin = $this->input('change_login_details') === 'on';

        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'edit_name' => ['required', 'string', 'max:255'],
            'edit_user_role_id' => ['required', 'array', 'min:1'],
            'edit_user_role_id.*' => ['required', 'integer', 'distinct', Rule::exists('roles', 'id')->where('active', 1)->where('guard_name', 'web')],
            'edit_user_group_id' => ['required', 'integer', 'exists:user_groups,id'],
            'edit_profile_pic' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'change_login_details' => ['nullable', 'in:on'],
            'edit_email' => $changeLogin ? ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore((int) $this->input('user_id'))] : ['exclude'],
            'edit_password' => $changeLogin ? ['nullable', 'string', 'min:5', 'max:72'] : ['exclude'],
            'edit_conform_password' => $changeLogin ? ['required_with:edit_password', 'nullable', 'same:edit_password'] : ['exclude'],
        ];
    }
}
