<?php


namespace ASPTest\Domain;

class User
{

    /** @var int $id */
    private $id;

    /** @var string $nome */
    private $nome;

    /** @var string $sobrenome*/
    private $sobrenome;

    /** @var string $email*/
    private $email;

    /** @var int $idade*/
    private $idade;

    /** @var string $senha */
    private $senha;


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

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getSobrenome(): string
    {
        return $this->sobrenome;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getIdade(): ?int
    {
        return $this->idade;
    }

    /**
     * @param string $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
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