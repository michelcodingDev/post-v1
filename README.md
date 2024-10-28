
Copiar código
# Projeto API Laravel para Gestão de Utilizadores

Este projeto fornece uma API RESTful construída com Laravel para gerir utilizadores. Inclui endpoints para autenticação, criação, atualização e exclusão de utilizadores.

## Funcionalidades

- Autenticação de utilizadores com geração de tokens.
- CRUD de utilizadores (criação, leitura, atualização e exclusão).
- Documentação automática da API com o Scribe.

## Pré-requisitos

Antes de começar, você precisará ter os seguintes softwares instalados na sua máquina:

- [PHP >= 8.0](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) ou outro sistema de base de dados suportado pelo Laravel
- [Laravel 9.x](https://laravel.com/)

## Configuração do Ambiente

1. **Clonar o repositório:**

 ```bash
   git clone https://github.com/seu_usuario/seu_repositorio.git
   cd seu_repositorio
  ```
## Instalar dependências do Composer:

  ```bash

composer update

  ```
 ```bash

php artisan key:generate
 ```

##  Executar as migrações para criar as tabelas no banco de dados:

 ```bash

php artisan migrate

  ```



## Acesso à Documentação
A documentação da API está disponível em http://localhost:8000/docs após a geração com o Scribe.

Executar a Aplicação
Inicie o servidor de desenvolvimento do Laravel:

 ```bash
php artisan serve
 ```
A aplicação estará disponível em http://localhost:8000.
