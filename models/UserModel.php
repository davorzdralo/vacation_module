<?php

namespace Models;

use App\Database;

class UserModel implements BaseModel {
    public $id;
    public $username;
    public $password;
    public $role;

    /**
     * Retrieves the model of the user from the databased based on ID.
     * @param number $id  ID of the user.
     * @return UserModel|null Returns model of the user if found, or NULL if there is no such user.
     */
    public static function find($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $connection = Database::getConnection();
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

    /**
     * Retrieves the model of the user from the databased based on ID.
     * @param string $username  ID of the user.
     * @return UserModel|null Returns model of the user if found, or NULL if there is no such user.
     */
    public static function findByUsername($username) {
        $query = "SELECT * FROM users WHERE username=:username";
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":username", $username);
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

    /**
     * Checks whether given username is already taken.
     * @param string $username  Username that we want to check.
     * @return bool Returns 'true' if the username is already taken, otherwise 'false'.
     */
    public static function usernameTaken($username) {
        $query = "SELECT id FROM users WHERE username = :username";
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch() ? true : false;
    }

    /**
     * Creates a new user in the database. The method uses PHPs default hashing
     * function 'password_hash' for hashing.
     * @param string $username Username for the new user.
     * @param string $password Password for the new user.
     * @param string $role Role for the new user. 'employee' is default role if
     *                  one isn't specified.
     * @return bool Returns true if operation was successful, otherwise false.
     */
    public static function register($username, $password, $role = 'employee') {
        $conn = Database::getConnection();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users(username, password, role) 
                                VALUES(:username, :password, :role)");

        $stmt->bindparam(":username", $username);
        $stmt->bindparam(":password", $hashedPassword);
        $stmt->bindparam(":role", $role);

        return $stmt->execute();
    }
}