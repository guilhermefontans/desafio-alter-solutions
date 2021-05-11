<?php


namespace ASPTest\Command;


use ASPTest\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class CreateUserPWDCommand extends Command
{
    private $userRepository;

    protected static $defaultName = 'USER-CREATE-PWD';

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Criar senha para usuário')
            ->addArgument('ID', InputArgument::REQUIRED, 'Id do usuário')
            ->setHelp("Este comando cria uma senha para o usuário informado");
    }
}