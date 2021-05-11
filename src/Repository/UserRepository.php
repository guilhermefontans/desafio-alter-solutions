<?php


namespace ASPTest\Repository;


use ASPTest\Domain\Factory\UserFactory;
use http\Exception\RuntimeException;

class UserRepository
{
    /** @var \PDO $connection */
    private $connection;

    /** @var UserFactory $userFactory */
    private $userFactory;

    public function __construct(\PDO $pdo, UserFactory $userFactory)
    {
        $this->connection  = $pdo;
        $this->userFactory = $userFactory;
    }

    public function persist($usuario)
    {
        try {
            $sql = "INSERT INTO usuario (nome, sobrenome, email, idade) VALUES (?, ?, ?, ?)";

            $statement = $this->connection->prepare($sql);
            $statement->execute([
                $usuario->getNome(),
                $usuario->getSobrenome(),
                $usuario->getEmail(),
                $usuario->getidade()
            ]);

            if (! $this->connection->lastInsertId()) {
                throw new RuntimeException('Erro ao salvar o usuário na base de dados');
            }
            $usuario->setId($this->connection->lastInsertId());
            return $usuario->getProperties();
        } catch (\Exception $exception) {
            throw new \Exception("Erro ao persistir usuário: ". $exception->getMessage());
        }
    }

    public function findById($id)
    {
        $sql = "SELECT id, nome, sobrenome, email, idade FROM usuario WHERE ID = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $result) {
            throw new \InvalidArgumentException("usuário não encontrado");
        }
        return $this->userFactory->newEntity($result);
    }

    public function update($usuario)
    {
        $sql = "UPDATE usuario SET nome = ?, sobrenome = ?, email = ?, idade = ?, senha = ? WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $result = $statement->execute([
            $usuario->getNome(),
            $usuario->getSobrenome(),
            $usuario->getEmail(),
            $usuario->getIdade(),
            $usuario->getSenha(),
            $usuario->getId()
        ]);

        if (! $result) {
            throw new \RuntimeException('Erro ao salvar o password do usuário');
        }
        return $this->connection->lastInsertId();
    }
}