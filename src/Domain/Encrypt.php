<?php

namespace ASPTest\Domain;

class Encrypt
{
    private $key = 'AlterSolutions21';

    private $custo = 10;

    public function hash($senha)
    {
        return crypt($senha,  $this->generateSalt($senha));
    }

    private function generateSalt($senha)
    {
        $mcrypt = $this->generateHashMcrypt($senha);

        //necessário converter para base64 devido a mcrypt criar binário
        $hashMcrypt = base64_encode($mcrypt);
        $salt = sprintf('$2a$%d$%s',
            $this->custo,
            substr(strtr($hashMcrypt, '+', '.'), 0, 22)
        );
        return $salt;
    }

    private function generateHashMcrypt($senha)
    {
        $hash = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->key, $senha, MCRYPT_MODE_ECB);
        return $hash;
    }
}