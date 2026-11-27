<?php

namespace App\Services\Users;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

final class ProfilePictureService
{
    public function upload(UploadedFile $file): string
    {
        Validator::make(['picture' => $file], [
            'picture' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ])->validate();

        $directory = 'assets/img/user';
        $filename = Str::uuid().'.'.$file->extension();
        $file->move(base_path($directory), $filename);

        return $directory.'/'.$filename;
    }
}
