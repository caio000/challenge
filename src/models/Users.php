<?php

namespace app\models;

use PDO;
use Exception;
use app\lib\db\Model;
use app\lib\db\Connection;
use app\lib\rest\IdentityInterface;

class Users extends Model implements IdentityInterface {

    public static function getUserByEmail(string $email) {
        $connection = Connection::getInstance();
        $query = "SELECT * FROM " . self::tablename() . " WHERE email = ?";

        $statement = $connection->prepare($query);
        $statement->execute([$email]);

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $user = new Users;
            $user->load($data);
            return $user;
        }

        return null;
    }

    public function beforeSave(bool $return): bool
    {
        $connection = Connection::getInstance();
        
        $query = "SELECT email FROM " .  $this->tablename() . " WHERE email = ?";
        if (isset($this->id)) {
            $query .= " AND id != ?";
            $data = [$this->email, $this->id];
        } else {
            $data = [$this->email];
        }
        $statement = $connection->prepare($query);
        if ($statement && $statement->execute($data)) {
            if ($statement->rowCount() >= 1) {
                throw new Exception("This user already exists.", 500);
            }
        }
        return $return;
    }

    public function beforeDelete(bool $return): bool
    {
        $connection = Connection::getInstance();

        // delete all the user drinks
        $query = "DELETE FROM Drinks WHERE id_user = ?";
        $statement = $connection->prepare($query);
        return $statement->execute([$this->id]);
    }

    public static function findByToken(string $token)
    {
        $connection = Connection::getInstance();

        $query = "SELECT * FROM ". self::tablename() . " WHERE token = ?";

        $statement = $connection->prepare($query);
        $statement->execute([$token]);

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $user = new Users;
            $user->load($data);
        }

        return $user ?? null;
    }

    public function getDrinks () {
        $connection = Connection::getInstance();

        $query = "SELECT * FROM Drinks WHERE id_user = ?";
        $statement = $connection->prepare($query);
        $statement->execute([$this->id]);

        $drinks = $statement->fetchAll(PDO::FETCH_CLASS, Drinks::class);
        return $drinks;
    }
}