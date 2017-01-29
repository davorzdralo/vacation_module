<?php

namespace App;

use Models\UserModel;

class UserAuth
{
    public static function initialise() {
        session_start();
    }

    public static function login($username, $password)
    {
        $user = UserModel::findByUsername($username);

        if($user != null && password_verify($password, $user->password)) {
            $_SESSION['user_object'] = $user;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns 'true' if user is logged in, otherwise returns 'false'.
     */
    public static function isLoggedIn() {
        return isset($_SESSION['user_object']);
    }

    public static function user() {
        return $_SESSION['user_object'];
    }

    public static function logout() {
        session_destroy();
        unset($_SESSION['user_object']);
        return true;
    }
}
