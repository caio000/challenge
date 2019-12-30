<?php

namespace app\models;

use app\lib\db\Connection;
use app\lib\db\Model;
use PDO;

class Drinks extends Model
{
    
    public static function getRanking ()
    {
        $connection = Connection::getInstance();
        $query = "SELECT 
            users.name,
            sum(drinks.drink_ml) as total_ml
        FROM drinks
            INNER JOIN
        users ON users.id = drinks.id_user
        GROUP BY drinks.id_user
        ORDER BY SUM(drinks.drink_ml) DESC";

        return $connection->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}
