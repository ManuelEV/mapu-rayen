<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers()
    {

        $users = User::select('users.id', 'users.name', 'users.email')
            ->orderBy('users.id', 'desc')
            ->get();
        return [
            'users' => $users
        ];

    }
}
