<?php


namespace Tests\Domain;

use ASPTest\Domain\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 *
 * @package Tests\Domain
 */
class UserTest extends TestCase
{

    public function userProvider()
    {
        return [
            [1, 'user', 'sobrenome do user', 'user@mail.com', 20, null],
            [null, 'user', 'sobrenome do user', 'user@mail.com', 20, null],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param $id
     * @param $nome
     * @param $sobrenome
     * @param $email
     * @param $idade
     * @param $senha
     */
    public function testGetters($id, $nome, $sobrenome, $email, $idade, $senha)
    {
        $user = new User($id, $nome, $sobrenome, $email, $idade, $senha);
        $this->assertEquals($id, $user->getId());
        $this->assertEquals($nome, $user->getNome());
        $this->assertEquals($sobrenome, $user->getSobrenome());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($idade, $user->getIdade());
    }
}