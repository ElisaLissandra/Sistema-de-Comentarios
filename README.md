
# Sistema de Comentários API

Esta é uma API RESTful construída com Laravel para gerenciar um sistema de comentários para posts e produtos. Ela inclui autenticação de usuário, operações CRUD para posts e produtos, e um sistema de comentários polimórfico, além de notificações em tempo real.

## Funcionalidades

- **Autenticação:** Registro de usuário, login e logout usando JWT.
- **Posts:** Operações CRUD completas (Criar, Ler, Atualizar, Deletar) para posts.
- **Produtos:** Operações CRUD completas para produtos.
- **Comentários:** Adicione comentários a posts ou produtos (relação polimórfica).
- **Notificações:** Usuários são notificados quando seus posts ou produtos recebem novos comentários.
- **Soft Deletes:** Posts, produtos e comentários podem ser "deletados" de forma suave (soft deleted) e restaurados.

## Tecnologias Utilizadas

- **Backend:** PHP 8.2, Laravel 12
- **Autenticação:** `php-open-source-saver/jwt-auth`
- **Banco de Dados:** SQLite (padrão), mas pode ser configurado para MySQL, PostgreSQL, etc.
- **Testes:** PHPUnit

## Pré-requisitos

- PHP >= 8.2
- Composer
- Um banco de dados de sua escolha (o padrão é SQLite)

## Instalação e Configuração

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/seu-usuario/seu-repositorio.git
    cd seu-repositorio
    ```

2.  **Instale as dependências do PHP:**
    ```bash
    composer install
    ```

3.  **Configure o ambiente:**
    - Copie o arquivo de ambiente de exemplo:
      ```bash
      cp .env.example .env
      ```
    - Gere a chave da aplicação:
      ```bash
      php artisan key:generate
      ```
    - Gere a chave secreta do JWT:
      ```bash
      php artisan jwt:secret
      ```

4.  **Configure o Banco de Dados:**
    - Crie um arquivo de banco de dados SQLite:
      ```bash
      touch database/database.sqlite
      ```
    - Ou configure suas credenciais de banco de dados no arquivo `.env` se estiver usando outro SGBD.

5.  **Execute as migrações e semeie o banco de dados:**
    Isso criará as tabelas e um usuário de teste.
    ```bash
    php artisan migrate --seed
    ```

## Executando a Aplicação

Para iniciar o servidor da aplicação, execute:
```bash
php artisan serve
```
O servidor estará disponível em `http://127.0.0.1:8000`.

Para processar as notificações na fila (que são geradas quando um comentário é criado), execute em um terminal separado:
```bash
php artisan queue:listen
```

## Endpoints da API

Todas as rotas (exceto login/registro) requerem um token JWT no cabeçalho `Authorization` como `Bearer <token>`.

### Autenticação

- `POST /api/register`: Registra um novo usuário.
- `POST /api/login`: Autentica um usuário e retorna um token JWT.
- `GET /api/logout`: Invalida o token do usuário autenticado.
- `GET /api/user`: Retorna as informações do usuário autenticado.

### Posts

- `GET /api/posts`: Lista todos os posts.
- `POST /api/posts`: Cria um novo post.
- `GET /api/posts/{post}`: Mostra um post específico.
- `PUT /api/posts/{post}`: Atualiza um post.
- `DELETE /api/posts/{post}`: Deleta um post (soft delete).
- `POST /api/posts/{id}/restore`: Restaura um post deletado.
- `DELETE /api/posts/{id}/force-delete`: Deleta um post permanentemente.

### Produtos

- `GET /api/products`: Lista todos os produtos.
- `POST /api/products`: Cria um novo produto.
- `GET /api/products/{product}`: Mostra um produto específico.
- `PUT /api/products/{product}`: Atualiza um produto.
- `DELETE /api/products/{product}`: Deleta um produto (soft delete).
- `POST /api/products/{id}/restore`: Restaura um produto deletado.
- `DELETE /api/products/{id}/force-delete`: Deleta um produto permanentemente.

### Comentários

- `POST /api/posts/{post}/comments`: Adiciona um comentário a um post.
- `POST /api/products/{product}/comments`: Adiciona um comentário a um produto.
- `GET /api/posts/{post}/comments`: Lista os comentários de um post.
- `GET /api/products/{product}/comments`: Lista os comentários de um produto.
- `DELETE /api/posts/comments/{comment}`: Deleta um comentário de um post.
- `DELETE /api/products/comments/{comment}`: Deleta um comentário de um produto.
- `POST /api/posts/comments/{id}/restore`: Restaura um comentário de um post.
- `POST /api/products/comments/{id}/restore`: Restaura um comentário de um produto.
- `DELETE /api/posts/comments/{id}/force-delete`: Deleta permanentemente um comentário de um post.
- `DELETE /api/products/comments/{id}/force-delete`: Deleta permanentemente um comentário de um produto.

### Notificações

- `GET /api/notification`: Lista as notificações do usuário autenticado.
- `POST /api/notification/mark-all-read`: Marca todas as notificações como lidas.
- `POST /api/notification/{notification}/mark-read`: Marca uma notificação específica como lida.

## Executando os Testes

Para rodar a suíte de testes automatizados, use o seguinte comando:

```bash
composer run test
```
ou
```bash
php artisan test
```
