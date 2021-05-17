<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function getById(int $id): ?self
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            return $user;
        }
        return null;
    }

    public function getByEmail(string $email): ?self
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return $user;
        }
        return null;
    }
}
