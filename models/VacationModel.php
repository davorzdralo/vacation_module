<?php

namespace Models;

use App\Database;
use PDO;

class VacationModel implements BaseModel {
    const VACATION_DAYS = 20;

    public $id;
    public $user_id;
    public $start;
    public $end;
    public $status;

    /** Relation */
    public $user;

    /**
     * Retrieves the model of the vacation from the databased based on ID.
     * @param $id number ID of the vacation.
     * @return VacationModel|null Returns model of the vacation if found, or NULL if there is no such vacation.
     */
    public static function find($id) {
        $connection = Database::getConnection();

        $query = "SELECT * FROM vacations WHERE id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();

        if($stmt->rowCount() == 1) {
            $vacation = new VacationModel();
            $vacation->id = $result['id'];
            $vacation->user_id = $result['user_id'];
            $vacation->start = $result['start'];
            $vacation->end = $result['end'];
            $vacation->status = $result['status'];

            $vacation->user = UserModel::find($vacation->user_id);
        } else {
            $vacation = null;
        }

        return $vacation;
    }

    /**
     * Inserts the model into the database. After insertion, the model ID will be set.
     * @return bool Returns true if operation was successful, otherwise false.
     */
    public function insert() {
        $connection = Database::getConnection();

        $query = "INSERT INTO vacations(user_id, start, end, status) VALUES (:user_id, :start, :end, :status)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":start", $this->start);
        $stmt->bindParam(":end", $this->end);
        $stmt->bindParam(":status", $this->status);
        $result = $stmt->execute();
        $this->id = $connection->lastInsertId();

        return $result;
    }

    /**
     * Updates the model in the database.
     * @return bool Returns true if operation was successful, otherwise false.
     */
    public function update() {
        $connection = Database::getConnection();

        $query = "UPDATE vacations SET user_id=:user_id, start=:start, end=:end, status=:status WHERE id=:id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":start", $this->start);
        $stmt->bindParam(":end", $this->end);
        $stmt->bindParam(":status", $this->status);
        return $stmt->execute();
    }

    /**
     * Returns all created vacations from the database. This method is intended
     * for internal use by this class (and so is private). It takes user ID as
     * parameter. If the user Id is specified, it will return only the vacations
     * for that user. Otherwise, if the user ID is NULL, it will return all
     * vacations.
     * @param $userId number|null ID of the user, or NULL.
     * @return array Array of vacation models.
     */
    private static function getAllVacationsHelper($userId) {
        $connection = Database::getConnection();

        $query = "
            SELECT v.id as vacation_id, start, end, status, u.id as user_id, username, password, role 
            FROM vacations AS v 
            JOIN users AS u ON v.user_id = u.id";

        if($userId != null)
            $query .= " WHERE user_id = :user_id";

        $stmt = $connection->prepare($query);
        if($userId != null)
            $stmt->bindParam(":user_id", $userId);
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

    /**
     * Retrieves all vacations recorded in the database.
     * @return array Returns an array of vacation models.
     */
    public static function getAll() {
        return self::getAllVacationsHelper(null);
    }

    /**
     * Retrieves all vacations recorded in the database for a given user.
     * @param $userId number ID of the user whose vacations we want to read.
     * @return array Returns an array of vacation models.
     */
    public static function getAllForUser($userId) {
        return self::getAllVacationsHelper($userId);
    }

    /**
     * Calculates and returns remaining vacation days. This method assumes that
     * there are no overlapping vacations, and that all vacations begin and end
     * in the same year. Only approved vacations are taken into consideration.
     * @param $user_id number ID of the user whose vacation days we want to calculate.
     * @return int Returns the number of remaining vacation days.
     */
    public static function remainingVacationDays($user_id) {
        $connection = Database::getConnection();

        $query = "SELECT sum(end - start) as days
                FROM vacations
                WHERE YEAR(start) = YEAR(CURDATE()) 
                    and status = 'approved' 
                    and user_id = :user_id";

        $stmt = $connection->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return max(self::VACATION_DAYS - $stmt->fetchColumn(), 0);
    }
}