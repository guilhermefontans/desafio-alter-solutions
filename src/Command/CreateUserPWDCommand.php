<?php

declare(strict_types=1);

namespace ASPTest\Command;

use ASPTest\Domain\Encrypt;
use ASPTest\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class CreateUserPWDCommand
 *
 * @package ASPTest\Command
 */
class CreateUserPWDCommand extends Command
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    /** @var Encrypt $encrypt */
    private $encrypt;

    protected static $defaultName = 'USER-CREATE-PWD';

    /**
     * CreateUserPWDCommand constructor.
     *
     * @param UserRepository $userRepository
     * @param Encrypt $encrypt
     */
    public function __construct(UserRepository $userRepository, Encrypt $encrypt)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->encrypt = $encrypt;
    }

    protected function configure()
    {
        $this
            ->setDescription('Criar senha para usuário')
            ->addArgument('ID', InputArgument::REQUIRED, 'Id do usuário')
            ->setHelp("Este comando cria uma senha para o usuário informado");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $idUsuario = $input->getArgument('ID');
            $usuario = $this->userRepository->findById($idUsuario);

            $senha = $this->getAnswers($input, $output);
            $senhaSegura = $this->encrypt->hash($senha);
            $usuario->setSenha($senhaSegura);
            $this->userRepository->update($usuario);
            $output->writeln('Senha salva com sucesso');
            return Command::SUCCESS;
        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return string
     */
    private function getAnswers(InputInterface $input, OutputInterface $output): string
    {
        $helper = $this->getHelper('question');
        $question = new Question('Informe a senha para o usuário: ');
        $question->setValidator(function ($senha) {
            $uppercase = preg_match('@[A-Z]@', $senha);
            $lowercase = preg_match('@[a-z]@', $senha);
            $number    = preg_match('@[0-9]@', $senha);
            $specialChars = preg_match('@[^\w]@', $senha);
            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($senha) < 6) {
                throw new \RuntimeException(
                    'A senha deve conter no mínimo 6 caracteres, sendo no mínimo uma letra maiúscula, um número, e um caractere especial'
                );
            }
            return $senha;
        });
        $question->setHidden(true);
        $question->setMaxAttempts(10);
        $senha = $helper->ask($input, $output, $question);

        $question = new Question('Digite novamente a senha: ');
        $question->setValidator(function ($senhaVerificada) use ($senha) {
            if ($senha !== $senhaVerificada) {
                throw new \RuntimeException(
                    'As senhas devem ser iguais'
                );
            }
            return $senhaVerificada;
        });
        $question->setHidden(true);
        $question->setMaxAttempts(10);
        $senhaVerificada = $helper->ask($input, $output, $question);
        return $senhaVerificada;
    }
}