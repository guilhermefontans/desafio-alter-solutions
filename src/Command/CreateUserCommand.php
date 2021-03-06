<?php

declare(strict_types=1);

namespace ASPTest\Command;

use ASPTest\Domain\Factory\UserFactory;
use ASPTest\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class CreateUserCommand
 *
 * @package ASPTest\Command
 */
class CreateUserCommand extends Command
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    /** @var UserFactory $userFactory */
    private $userFactory;

    protected static $defaultName = 'USER-CREATE';


    public function __construct(UserRepository $userRepository, UserFactory $userFactory)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
    }

    protected function configure()
    {
        $this
            ->setDescription('Criar um novo usuário')
            ->setHelp("Este comando cria um novo usuário na base de dados de acordo com os dados informados");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $data = $this->getAnswers($input, $output);
            $user = $this->userFactory->newEntity($data);
            $userCreated =  $this->userRepository->persist($user);
            $output->writeln(\json_encode($userCreated));
            return Command::SUCCESS;
        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return array
     */
    private function getAnswers(InputInterface $input, OutputInterface $output): array
    {
        $helper = $this->getHelper('question');
        $question = new Question('Informe o nome do usuário: ');
        $question->setValidator(function ($nome) {
            if (strlen($nome) < 2 || strlen($nome) > 35) {
                throw new \RuntimeException(
                    'O nome deve conter mais de 2 caracteres e menos que 35'
                );
            }
            return $nome;
        });
        $question->setMaxAttempts(2);
        $nome = $helper->ask($input, $output, $question);

        $question = new Question('Informe o sobrenome do usuário: ');
        $question->setValidator(function ($sobrenome) {
            if (strlen($sobrenome) < 2 || strlen($sobrenome) > 35) {
                throw new \RuntimeException(
                    'O sobrenome deve conter mais de 2 caracteres e menos que 35'
                );
            }
            return $sobrenome;
        });
        $question->setMaxAttempts(2);
        $sobrenome = $helper->ask($input, $output, $question);

        $question = new Question('Informe o email do usuário: ');
        $question->setValidator(function ($email) {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException(
                    'O email está no formato inválido'
                );
            }
            return $email;
        });
        $question->setMaxAttempts(2);
        $email = $helper->ask($input, $output, $question);

        $question = new Question('Informe a idade do usuário(opcional): ', null);
        $question->setValidator(function ($idade) {
            if (isset($idade) && $idade < 0 || $idade > 150) {
                throw new \RuntimeException(
                    'Idade inválida'
                );
            }
            return $idade;
        });
        $question->setMaxAttempts(2);
        $idade = $helper->ask($input, $output, $question);

        return [
            'nome'      => $nome,
            'sobrenome' => $sobrenome,
            'email'     => $email,
            'idade'     => $idade
        ];
    }
}