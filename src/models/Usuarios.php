<?php

namespace app\models;

use app\lib\db\Connection;
use app\lib\db\Model;
use PDO;

class Usuarios extends Model
{
    /**
     * Verifica se existe algum usuário cadastrado na base de dados de acordo
     * com o campo informado como parâmetro
     * @param string $key por exemplo, email.
     * @return bool se já existir retorna true.
     */
    public function alreadyExistsBy(string $key): bool
    {
        $result = false;
        $connection = Connection::getInstance();

        $query = "SELECT
            COUNT(*) AS qtd
        FROM " . self::tablename() . "
        WHERE
            {$key} = :value
        AND id != :id";
        $statement = $connection->prepare($query);
        $statement->bindValue(':value', $this->$key);
        $statement->bindValue(':id', $this->id ?? 0);

        if ($statement && $statement->execute()) {
            if ((int) $statement->fetch(PDO::FETCH_ASSOC)['qtd'] !== 0) {
                $result = true;
            }
        }

        return $result;
    }
}