<?php


namespace Tests\Domain\Factory;


use ASPTest\Domain\Factory\UserFactory;
use ASPTest\Domain\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserFactoryTest
 * @package Tests\Domain\Factory
 */
class UserFactoryTest extends TestCase
{
    /** @var UserFactory */
    private $userFactory;

    public function setUp(): void
    {
        $this->userFactory = new UserFactory();
    }

    public function userProvider()
    {
        return [
            [1, 'user', 'sobrenome do user', 'user@mail.com', 20],
            [null, 'user', 'sobrenome do user', 'user@mail.com', 20],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param $id
     * @param $nome
     * @param $sobrenome
     * @param $email
     * @param $idade
     */
    public function testCreateEntity($id, $nome, $sobrenome, $email, $idade)
    {
        $user = $this->userFactory->newEntity([
            'id'        => $id,
            'nome'      => $nome,
            'sobrenome' => $sobrenome,
            'email'     => $email,
            'idade'     => $idade
        ]);
        $this->assertInstanceOf(User::class, $user);
    }
}