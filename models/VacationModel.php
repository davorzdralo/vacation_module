<?php

namespace Models;

use App\Database;
use PDO;

class VacationModel {
    public $id;
    public $user_id;
    public $start;
    public $end;
    public $status;

    /** Relation */
    public $user;

    public static function find($id) {
        $database = new Database();
        $connection = $database->dbConnection();

        $query = "SELECT * FROM vacations WHERE id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();

        if($stmt->rowCount() == 1) {
            $model = new VacationModel();
            $model->id = $result['id'];
            $model->user_id = $result['user_id'];
            $model->start = $result['start'];
            $model->end = $result['end'];
            $model->status = $result['status'];
        } else {
            $model = null;
        }

        return $model;
    }

    public function insert() {

        $database = new Database();
        $connection = $database->dbConnection();

        $query = "INSERT INTO vacations(user_id, start, end, status) VALUES (:user_id, :start, :end, :status)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":start", $this->start);
        $stmt->bindParam(":end", $this->end);
        $stmt->bindParam(":status", $this->status);
        $stmt->execute();

        $this->id = $connection->lastInsertId();

        return $stmt;
    }

    public function save() {
        $database = new Database();
        $connection = $database->dbConnection();

        $query = "UPDATE vacations SET user_id=:user_id, start=:start, end=:end, status=:status WHERE id=:id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":start", $this->start);
        $stmt->bindParam(":end", $this->end);
        $stmt->bindParam(":status", $this->status);
        $stmt->execute();

        return $stmt;
    }

    public static function getAll() {
        $database = new Database();
        $connection = $database->dbConnection();

        $query = "SELECT v.id as vacation_id, start, end, status, u.id as user_id, username, password, role 
            FROM vacations AS v 
            JOIN users AS u ON v.user_id = u.id";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $vacations = [];
        foreach ($results as $vacation) {
            $model = new VacationModel();

            $model->id = $vacation['vacation_id'];
            $model->user_id = $vacation['user_id'];
            $model->start = $vacation['start'];
            $model->end = $vacation['end'];
            $model->status = $vacation['status'];

            $model->user = new UserModel();
            $model->user->id = $vacation['user_id'];
            $model->user->username = $vacation['username'];
            $model->user->password = $vacation['password'];
            $model->user->role = $vacation['role'];

            $vacations[] = $model;
        }

        return $vacations;
    }

    public static function getAllForUser($userId) {
        $database = new Database();
        $connection = $database->dbConnection();

        $query = "SELECT * FROM vacations WHERE user_id = :user_id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $vacations = [];
        foreach ($results as $vacation) {
            $model = new VacationModel();

            $model->id = $vacation['id'];
            $model->user_id = $vacation['user_id'];
            $model->start = $vacation['start'];
            $model->end = $vacation['end'];
            $model->status = $vacation['status'];

            $vacations[] = $model;
        }

        return $vacations;
    }

    public static function remainingVacationDays($user_id) {
        $database = new Database();
        $connection = $database->dbConnection();

        $query = "SELECT sum(end - start) as days
                FROM vacations
                WHERE YEAR(start) = YEAR(CURDATE()) 
                    and status = 'approved' 
                    and user_id = :user_id";

        $stmt = $connection->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return 20 - $stmt->fetchColumn();
    }
}