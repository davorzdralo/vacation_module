<?php

namespace Models;

use App\Database;

class UserModel {
    public $id;
    public $username;
    public $password;
    public $role;

    public static function find($id) {
        $database = new Database();
        $connection = $database->dbConnection();

        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();

        if($stmt->rowCount() == 1) {
            $user = new UserModel();
            $user->id = $result['id'];
            $user->username = $result['username'];
            $user->password = $result['password'];
            $user->role = $result['role'];
        } else {
            $user = null;
        }

        return $user;
    }

    public static function usernameTaken($username) {
        $database = new Database();
        $connection = $database->dbConnection();

        $query = "SELECT id FROM users WHERE username = :username";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch() ? true : false;
    }
}