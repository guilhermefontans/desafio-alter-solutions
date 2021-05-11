<?php


namespace ASPTest;

class User
{

    /** @var int $id */
    private $id
    /** @var string $nome */
    private $nome;

    /** @var string $sobrenome*/
    private $sobrenome;

    /** @var string $email*/
    private $email;

    /** @var int $idade*/
    private $idade;

    /** @var string $password */
    private $password;

    /**
     * User constructor.
     * @param $nome
     * @param $sobrenome
     * @param $email
     * @param $idade
     */
    public function __construct(?int $id, string $nome, string $sobrenome, string $email, ?int $idade)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->email = $email;
        $this->idade = $idade;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getProperties()
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'email' => $this->email,
            'idade' => $this->idade
        ];
    }
}