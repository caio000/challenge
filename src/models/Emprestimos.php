<?php

namespace app\models;

use app\lib\db\Connection;
use app\lib\db\Model;
use app\lib\db\Query;
use PDO;

class Emprestimos extends Model
{

    const SITUACAO_EMPRESTADO = 'emprestado';
    const SITUACAO_DEVOLVIDO = 'devolvido';

    public static function getLivrosEmprestados()
    {
        $result = null;
        $connection = Connection::getInstance();
        $filter = [
            'situacao' => self::SITUACAO_EMPRESTADO
        ];

        $query = new Query;
        $query->from(self::tablename())->where($filter);
        $statement = $connection->prepare($query->getQuery());
        if ($statement && $statement->execute($filter)) {
            $result = $statement->fetchAll(PDO::FETCH_CLASS, get_called_class());
        }

        return $result;
    }

    /**
     * busca os dados do usuário
     * @return Usuarios
     */
    public function getUsuario(): Usuarios
    {
        return Usuarios::findOne($this->id_usuario);
    }

    /**
     * busca os dados do livro
     * @return Livros
     */
    public function getLivro(): Livros
    {
        return Livros::findOne($this->id_livro);
    }

    /**
     * define os campos que a aplicação não pode atualizar,
     * mas nada impede que o banco de dados possa atualizar
     * esses dados
     * @return array
     */
    protected static function dontUpdate(): array
    {

        return [
            'id',
            'criado_em',
            'alterado_em',
        ];
    }

    /**
     * verifica a disponibilidade do livro
     * @return bool retorna true se o livro esta disponivel
     */
    public function checkDisponibilidade(): bool
    {
        $result = true;
        $connection = Connection::getInstance();
        $filter = [
            'situacao' => Emprestimos::SITUACAO_EMPRESTADO,
            'id_livro' => $this->id_livro,
        ];
        $query = new Query;
        $query->select(['COUNT(*) AS qtd'])
        ->from(self::tablename())
        ->where($filter);

        $statement = $connection->prepare($query->getQuery());
        if ($statement && $statement->execute($filter)) {
            if ((int) $statement->fetch(PDO::FETCH_ASSOC)['qtd'] !== 0) {
                $result = false;
            }
        }

        return $result;
    }
}