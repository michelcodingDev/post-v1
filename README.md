rojeto API Laravel para Gestão de Utilizadores
Este projeto fornece uma API RESTful construída com Laravel para gerir utilizadores. Inclui endpoints para autenticação, criação, atualização e exclusão de utilizadores.

Funcionalidades
Autenticação de utilizadores com geração de tokens.
CRUD de utilizadores (criação, leitura, atualização e exclusão).
Documentação automática da API com o Scribe.
Pré-requisitos
Antes de começar, você precisará ter os seguintes softwares instalados na sua máquina:

PHP >= 8.0
Composer
MySQL ou outro sistema de base de dados suportado pelo Laravel
Laravel 9.x
Configuração do Ambiente
Clonar o repositório:

bash
Copiar código
git clone https://github.com/seu_usuario/seu_repositorio.git
cd seu_repositorio
Instalar dependências do Composer:

bash
Copiar código
composer install
Configurar o arquivo .env:

Renomeie o arquivo .env.example para .env e configure as seguintes variáveis com as suas credenciais de base de dados:

env
Copiar código
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco_de_dados
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
Gerar a chave da aplicação:

bash
Copiar código
php artisan key:generate
Executar as migrações para criar as tabelas no banco de dados:

bash
Copiar código
php artisan migrate
Configurar o Scribe para documentar a API:

Instale o Scribe como dependência de desenvolvimento e publique o arquivo de configuração.

bash
Copiar código
composer require --dev knuckleswtf/scribe
php artisan scribe:install
Gerar a documentação da API:

Execute o comando abaixo para gerar a documentação e disponibilizá-la em public/docs.

bash
Copiar código
php artisan scribe:generate
Endpoints da API
1. Autenticação
Login do Utilizador

POST /api/login
Parâmetros:
email (string) - Email do utilizador
password (string) - Senha do utilizador
Resposta de sucesso: 200 OK com o token de autenticação.
Logout do Utilizador

POST /api/logout
Cabeçalho: Authorization: Bearer {token}
Resposta de sucesso: 200 OK.
2. Endpoints de Utilizadores
Listar Todos os Utilizadores

GET /api/users
Cabeçalho: Authorization: Bearer {token}
Resposta de sucesso: 200 OK com uma lista de utilizadores.
Ver Perfil do Utilizador Autenticado

GET /api/user
Cabeçalho: Authorization: Bearer {token}
Resposta de sucesso: 200 OK com os detalhes do utilizador.
Atualizar Perfil do Utilizador Autenticado

PUT /api/user
Parâmetros:
name (string) - Nome do utilizador
email (string) - Email do utilizador
password (string) - Nova senha do utilizador
Cabeçalho: Authorization: Bearer {token}
Resposta de sucesso: 201 Created.
Excluir Conta do Utilizador Autenticado

DELETE /api/user
Cabeçalho: Authorization: Bearer {token}
Resposta de sucesso: 200 OK.
3. Criar Novo Utilizador
Criar Utilizador

POST /api/register
Parâmetros:
name (string) - Nome do utilizador
email (string) - Email do utilizador (deve ser único)
password (string) - Senha do utilizador (mínimo 8 caracteres)
Resposta de sucesso: 201 Created.
Acesso à Documentação
A documentação da API está disponível em http://localhost:8000/docs após a geração com o Scribe.

Executar a Aplicação
Inicie o servidor de desenvolvimento do Laravel:

bash
Copiar código
php artisan serve
A aplicação estará disponível em http://localhost:8000.
