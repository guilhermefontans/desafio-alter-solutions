<?php


namespace ASPTest\Domain\Factory;


use ASPTest\Domain\User;

class UserFactory
{
    public function newEntity(array $data)
    {
        return new User(
            $data['id'] ?? null,
            $data['nome'],
            $data['sobrenome'],
            $data['email'],
            $data['idade'] ?? null
        );
    }
}