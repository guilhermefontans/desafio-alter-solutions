<?php

namespace Tests\Command;

use ASPTest\Command\CreateUserPWDCommand;
use ASPTest\Domain\Encrypt;
use ASPTest\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class CreateUserCommandTest
 *
 * @package Tests\Command
 */
class CreateUserCommandPWDTest extends TestCase
{

    private $userRepository;

    private  $encrypt;

    private $pdo;

    private $createUserPWDCommand;

    private $application;

    private $commandTester;

    public function setUp(): void
    {
        $this->userRepository = $this->prophesize(UserRepository::class);
        $this->pdo = $this->prophesize(\PDO::class);
        $this->encrypt = $this->prophesize(Encrypt::class);

        $this->createUserPWDCommand = new CreateUserPWDCommand(
            $this->userRepository->reveal(),
            $this->encrypt->reveal()
        );

        $this->application = new Application();
        $this->application->add($this->createUserPWDCommand);

        $this->commandTester = new CommandTester($this->createUserPWDCommand);
    }

    public function testCorrectAnswers()
    {
        $this->commandTester->setInputs(['guilherme']);
        $this->commandTester->execute([
            'command' => $this->createUserPWDCommand->getName(),
            'ID' => 1
        ]);

        $this->assertRegExp('/.*nforme a senha.*/', $this->commandTester->getDisplay());
    }


    public function testIncorrectPassword()
    {
        $this->commandTester->setInputs(['asd', 'W@dfa123']);
        $this->commandTester->execute([
            'command' => $this->createUserPWDCommand->getName(),
            'ID' => 1
        ]);
        $this->assertRegExp('/.*A senha deve conter.*/', $this->commandTester->getDisplay());

    }

    public function testCorrectPassword()
    {
        $this->commandTester->setInputs(['W@dfa123']);
        $this->commandTester->execute([
            'command' => $this->createUserPWDCommand->getName(),
            'ID' => 1
        ]);
        $this->assertRegExp('/.*Digite novamente.*/', $this->commandTester->getDisplay());

    }

    public function testInCorrectSecondPassword()
    {
        $this->commandTester->setInputs(['W@dfa123', 'W@dfa1as']);
        $this->commandTester->execute([
            'command' => $this->createUserPWDCommand->getName(),
            'ID' => 1
        ]);
        $this->assertRegExp('/.*As senhas devem ser iguais.*/', $this->commandTester->getDisplay());
    }

    public function testExecuteCommandWithoutParameter()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "ID")');
        $this->commandTester->execute([
            'command' => $this->createUserPWDCommand->getName(),
        ]);
    }
}