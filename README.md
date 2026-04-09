# Fintech Wallet

Aplicação web de carteira digital desenvolvida com Laravel 12, Vue 3 e MySQL para simular um fluxo simples de transferências entre usuários. O sistema permite cadastro de usuário, autenticação, visualização de saldo, envio de transferências, listagem das últimas movimentações e histórico com filtros por tipo e período.

## Decisões técnicas

`Backend:`
- Arquitetura backend organizada em camadas, com controllers para HTTP, requests para validação de entrada e services para concentrar as regras de negócio, seguindo padrões `SOLID`.
- Validações centralizadas em FormRequests.
- Autenticação web por sessão e autenticação de API com Laravel Sanctum.
- Banco de dados MySQL com modelagem baseada em `users`, `wallets`, `transfers` e `transaction_histories`.
- Modelagem do banco baseada separando saldo atual do histórico de movimentações e das transferências.
- Criação automática de carteira no ciclo de vida do usuário, garantindo que novas contas já nasçam prontas para participar das regras do domínio.

`Frontend`
- Vue.js, componentes separados por camadas.
- Blade para estrutura das paginas e Vue.js para interações.
- Separação das páginas Vue por contexto de uso, como dashboard, criação de transferência e listagem, facilitando manutenção.
- Estratégia de `UI` orientada a feedback imediato, com estados de carregamento, sucesso e erro no formulário de transferência.
- Uso de `Axios` no frontend para envio `assíncrono` de transferências, `melhorando feedback` ao usuário sem recarregar a página.

## Pré-requisitos

Para rodar localmente sem Docker:

- PHP 8.2+
- Composer 2+
- Node.js 20.19.0+ (`.nvmrc` usa `20.19.0`)
- npm 10+
- MySQL 8+

Para rodar com Docker:

- Docker
- Docker Compose

## Instalação das dependências

### Opção 1: ambiente local

1. Clone o repositório.
2. Entre na pasta do projeto.
3. Instale as dependências do backend:

```bash
composer install
```

4. Instale as dependências do frontend:

```bash
npm install
```

### Opção 2: ambiente com Docker

1. Clone o repositório.
2. Entre na pasta do projeto.
3. Suba os containers:

```bash
docker compose up -d --build
```
```bash
docker compose exec app
```
```bash
composer install
```
```bash
cp .env.example .env
```
```bash
php artisan key:generate
```
```bash
php artisan migrate --seed
```
Isso irá:
- criar as tabelas da aplicação;
- criar o usuário seed principal;
- gerar usuários adicionais com factory;
- criar uma carteira para cada usuário.
  
```bash
chmod -R 777 storage bootstrap/cache
```

O serviço `vite` já executa `npm install` automaticamente ao subir o ambiente.

## Configuração do `.env`

Exemplo de configuração padrão do projeto:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### Ajuste para rodar sem Docker

Se for usar MySQL instalado localmente, altere ao menos:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
APP_URL=http://127.0.0.1:8000
```

## Como iniciar o servidor

### Ambiente local

Terminal 1:

```bash
php artisan serve
```

Terminal 2:
Obs: Rodar dentro do container do Vite.
```bash
npm run dev
```

A aplicação ficará disponível em:

- Web: `http://localhost`
- Vite: `http://localhost:5173`
- MySQL: `127.0.0.1:3306`

## Scripts úteis

```bash
composer run test
```

```bash
npm run build
```

```bash
composer run dev
```

## Credenciais do usuário seed para teste

Usuário principal criado pelo `UserSeeder`:

- E-mail: `admin@email.com`
- Senha: `admin`
- Saldo inicial: `R$ 1.000,00`

## Link do deploy público



## Observações

- O projeto usa MySQL no `.env.example` e no `docker-compose.yml`.
- O container `db` expõe a porta `3306` e usa as credenciais padrão `laravel/secret`.
- Seed cria usuários extras via factory para facilitar testes de transferência entre contas.
