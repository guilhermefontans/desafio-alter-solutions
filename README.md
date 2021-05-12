
### Descrição

Este projeto consiste em criar um comando cli para fazer o cadastro de um usuário no banco de dados e outro comando para efetuar a inserção da senha.<br>
O desenvolvimento desse projeto foi efetuado utilizando as seguintes ferramentas: 

* [Docker](https://docs.docker.com/) para configurar o ambiente de desenvolvimento;
* [Docker Compose](https://docs.docker.com/compose/compose-file/) para fazer a orquestração dos containers docker;
* [Composer](https://getcomposer.org/) para o gerenciamento das bibliotecas utilizadas;
* [Symfony Console](https://symfony.com/doc/current/components/console.html) para auxiliar na criação dos comandos;
* [Phinx](https://phinx.org/) para controle de migrations do projeto;
* [PHPUnit](https://phpunit.de/) para criação de testes unitários.


#### Estrutura

A estrutura de pastas que estão dentro da pasta `src` mantém as camadas separadas, facilitando o entendimento do que cada uma é responsável:
```
- Command: Este módulo é o resposável por manter os arquivos que irão extender o componente do console do symfony, vindo a criar os comandos solicitados em UC-001 e UC-002
um arquivo que trata cada rota definida para o serviço.

- Domain: Essa pasta é responsável por conter as classes de regras de negócio.

- Repository: Essa camada é a responsável pela busca e inserção no banco de dados
```
Além das pastas citadas acima, também tem a pasta `db`, que contém as migrations da aplicação, e a pasta `tests`, que contém os testes unitários.

#### Pré requisitos para ambiente de desenvolvimento
Para rodar o projeto é necessário atender os seguintes requisitos:
* Ter o [Docker](https://docs.docker.com/install/linux/docker-ce/debian/) na máquina que irá subir o projeto.
* Ter o [Docker Compose](https://docs.docker.com/compose/install/) na máquina que irá subir o projeto.  

#### Instalação
Tendo os pré-requisitos preenchidos, para a instalação é necessário seguir os seguintes passos:

1. Fazer uma cópia do arquivo .env.exemplo para .env na raiz do projeto
```sh
$ cp .env.exemplo .env
```
2. Rodar o comando abaixo para subir os containers necessários: 
```sh
$ docker-compose up -d
```
3. Rodar o comando abaixo para instalar as dependências do projeto: 
```sh
$ docker run  --rm  --volume $PWD:/app --user $(id -u):$(id -g)   composer install --ignore-platform-reqs
``` 
4. Rodar o comando abaixo para que seja criado a tabela que será utilizada:
```
$ docker exec asp-app php vendor/bin/phinx  migrate
```
  
#### Comandos disponíveis:

Para executar os comandos você pode entrar no container asp-app e executá-los de dentro dele, ou então rodar da sua maquina local através do comando `docker exec` conforme descrito abaixo.<br>

##### Cadastrar um usuário:
```sh
$ docker exec -it asp-app ./ASP-TEST USER-CREATE
```
Após a execução do comando deverá ser preenchido as informações conforme solicitado pela aplicação. No fim terá sido criado o usuário na tabela `usuario`

##### Cadastrar uma senha para o usuário:
```sh
$ docker exec -it asp-app ./ASP-TEST USER-CREATE-PWD {ID}
```
Após informar a senha e confirmar ela novamente, será setado o campo `senha` do usuário cujo ID foi informado no comando

##### Rodar os testes unitários
```sh
$ docker exec asp-app vendor/bin/phpunit tests
```