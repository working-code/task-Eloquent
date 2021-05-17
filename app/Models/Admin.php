<?php

namespace App\Models;

class Admin extends User
{
    protected $table = 'users';

    public function isAdmin()
    {
        return $this->id === USER_ADMIN_ID;
    }

    public function getUsers(): array
    {
        $users = Admin::all('id', 'name', 'email', 'date_registration');
        if ($users->count()) {
            return $users->toArray();
        }
        return [];
    }

    public function deleteUserFromId(int $userId)
    {
        $user = Admin::find($userId);
        $user->delete();
    }

    public function saveUser($id, $name, $email)
    {
        $user = Admin::find($id);
        $user->name = $name;
        $user->email = $email;
        $user->save();
    }

    public function createUser($name, $password, $email, $date)
    {
        $user = new Admin;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->date_registration = $date;
        $user->save();
    }
}
