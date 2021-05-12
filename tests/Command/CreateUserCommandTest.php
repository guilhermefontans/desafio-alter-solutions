<?php

namespace Tests\Command;

use ASPTest\Command\CreateUserCommand;
use ASPTest\Domain\Factory\UserFactory;
use ASPTest\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class CreateUserCommandTest
 *
 * @package Tests\Command
 */
class CreateUserCommandTest extends TestCase
{

    private $userRepository;

    private  $userFactory;

    private $pdo;

    private $createUserCommand;

    private $application;

    private $commandTester;

    public function setUp(): void
    {
        $this->userRepository = $this->prophesize(UserRepository::class);
        $this->pdo = $this->prophesize(\PDO::class);
        $this->userFactory = $this->prophesize(UserFactory::class);

        $this->createUserCommand = new CreateUserCommand(
            $this->userRepository->reveal(),
            $this->userFactory->reveal()
        );

        $this->application = new Application();
        $this->application->add($this->createUserCommand);

        $this->commandTester = new CommandTester($this->createUserCommand);
    }

    public function testCorrectAnswers()
    {
        $this->commandTester->setInputs(['guilherme', 'nunes', 'mails@gmail.com', 20]);
        $this->commandTester->execute([
            'command' => $this->createUserCommand->getName(),
        ]);

        $this->assertRegExp('/.*nforme o nome.*/', $this->commandTester->getDisplay());
        $this->assertRegExp('/.*nforme o sobrenome.*/', $this->commandTester->getDisplay());
        $this->assertRegExp('/.*nforme o email.*/', $this->commandTester->getDisplay());
        $this->assertRegExp('/.*nforme a idade.*/', $this->commandTester->getDisplay());
    }

    public function testIncorrectAnswers()
    {
        $this->commandTester->setInputs(['a', 'a']);
        $this->commandTester->execute([
            'command' => $this->createUserCommand->getName(),
        ]);
        $this->assertRegExp('/.*O nome deve conter mais de 2 cara.*/', $this->commandTester->getDisplay());

        $this->commandTester->setInputs(['aaaa', 'a']);
        $this->commandTester->execute([
            'command' => $this->createUserCommand->getName(),
        ]);
        $this->assertRegExp('/.*O sobrenome deve conter mais de 2 cara.*/', $this->commandTester->getDisplay());

        $this->commandTester->setInputs(['aaaa', 'aaaa', 'mail@mail']);
        $this->commandTester->execute([
            'command' => $this->createUserCommand->getName(),
        ]);
        $this->assertRegExp('/.*O email está no formato inválid.*/', $this->commandTester->getDisplay());

        $this->commandTester->setInputs(['aaaa', 'aaaa', 'mail@mail.com', -15]);
        $this->commandTester->execute([
            'command' => $this->createUserCommand->getName(),
        ]);
        $this->assertRegExp('/.*Idade inválida.*/', $this->commandTester->getDisplay());
    }
}