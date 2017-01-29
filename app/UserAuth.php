<?php

namespace App;

use Models\UserModel;
use PDOException;

class UserAuth
{
    public static function initialise() {
        session_start();
    }

    // TODO: refaktorisati, prebaciti u model User
    public static function register($username, $password, $role = 'employee')
    {
        $database = new Database();
        $conn = $database->dbConnection();


        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users(username, password, role) 
                                VALUES(:username, :password, :role)");

        $stmt->bindparam(":username", $username);
        $stmt->bindparam(":password", $hashedPassword);
        $stmt->bindparam(":role", $role);

        return $stmt->execute();
    }


    public static function login($uname, $upass)
    {
        try
        {
            $database = new Database();
            $db = $database->dbConnection();

            // TODO: refaktorisati i koristiti ORM model
            $stmt = $db->prepare("SELECT id, username, password, role
                    FROM users WHERE username=:username ");
            $stmt->execute([':username'=>$uname]);

            $userRow=$stmt->fetch();

            if($stmt->rowCount() == 1) {
                $user = new UserModel();
                $user->id = $userRow['id'];
                $user->username = $userRow['username'];
                $user->password = $userRow['password'];
                $user->role = $userRow['role'];
            } else {
                $user = null;
            }


            if($user != null && password_verify($upass, $user->password)) {
                $_SESSION['user_object'] = $user;
                return true;
            } else {
                return false;
            }

        } catch(PDOException $e) {
            die($e->getMessage());
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
