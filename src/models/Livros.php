<?php

namespace app\models;

use app\lib\db\Connection;
use app\lib\db\Model;
use PDO;

class Livros extends Model
{
    /**
     * busca os dados da editora no livro
     * @return Editora
     */
    public function getEditora(): Editoras
    {
        return Editoras::findOne($this->id_editora);
    }

    /**
     * Busca os livros atraves do filtro passado como parâmetro.
     * @param array $filter
     * @return array lista de livros
     */
    public static function findByFilter(array $filter): array
    {
        $connection = Connection::getInstance();
        $query = "SELECT
            *
        FROM " . self::tablename() . "
        WHERE 1 ";
        if (isset($filter['nome']) && !empty($filter['nome'])) {
            $query.= " AND nome LIKE :nome";
        }
        if (isset($filter['editora']) && !empty($filter['editora'])) {
            $query.= " AND id_editora = :editora";
        }

        $statement = $connection->prepare($query);
        $statement->execute($filter);

        return $statement->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }
}