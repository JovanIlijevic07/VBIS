<?php
namespace App\Core;

class Auth
{
    public static function check()
    {
        Session::start();
        return [
            'isLoggedIn' => Session::isLoggedIn(),
            'username'   => Session::get('username') ?? '',
            'isAdmin'    => Session::isAdmin()
        ];
    }
}
