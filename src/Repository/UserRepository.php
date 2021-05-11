<?php


namespace ASPTest\Repository;


class UserRepository
{
    /** @var \PDO $connection */
    private $connection;

    public function __construct(\PDO $pdo)
    {
        $this->connection = $pdo;
    }

    public function persist($data)
    {
        try {

            $sql = "INSERT INTO usuario (nome, sobrenome, email, idade) VALUES (?, ?, ?, ?)";

            $statement = $this->connection->prepare($sql);
            $statement->execute([
                $data['nome'],
                $data['sobrenome'],
                $data['email'],
                $data['idade']
            ]);
            return $this->connection->lastInsertId();
        } catch (\Exception $exception) {
            throw new \Exception("Erro ao persistir usuário: ". $exception->getMessage());
        }
    }
}