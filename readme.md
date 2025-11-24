# Docker Setup para Laravel 12 com Schedule e Supervisor

## Estrutura do Projeto

```
docker-compose.yml       # Configuração dos containers
reserva-app   #api laravel para reservas
docker/
├── nginx/              # Configuração do Nginx
│   └── conf.d/
│       └── default.conf
├── php/                # Configuração do PHP
│   └── dockerfile
└── supervisor/         # Configuração do Supervisor
    ├── supervisord.conf
    ├── conf.d/
    │   ├── laravel-schedule.conf
    │   └── laravel-queue.conf
    └── logs/
```

## Containers

- **app**: Container PHP-FPM com Laravel
- **scheduler**: Container para executar o schedule e queue com Supervisor
- **nginx**: Container com Nginx para servir a aplicação
- **db**: Container MySQL 8.0

## Como Usar

### 1. Clonar o repositório

```bash
git clone <seu-repo>
cd Laravel
```

### 2. Configurar o ambiente

```bash
cp .env.example .env
```

### 3. Criar e iniciar os containers

```bash
docker-compose up -d
```

### 4. Instalar dependências PHP

```bash
docker-compose exec app composer install
```

### 5. Gerar chave da aplicação

```bash
docker-compose exec app php artisan key:generate
```

### 6. Executar migrations

```bash
docker-compose exec app php artisan migrate
```

### 7. Executar seeders (opcional)

```bash
docker-compose exec app php artisan db:seed
```

## Comandos Úteis

### Ver logs do schedule

```bash
docker-compose logs -f scheduler
# ou
docker-compose exec scheduler supervisorctl status laravel-schedule
```

### Ver logs da fila

```bash
docker-compose exec scheduler supervisorctl tail laravel-queue
```

### Ver status de todos os processos

```bash
docker-compose exec scheduler supervisorctl status
```

### Reiniciar um processo

```bash
docker-compose exec scheduler supervisorctl restart laravel-schedule
```

### Acessar o PHP CLI

```bash
docker-compose exec app bash
```

### Acessar o container do scheduler

```bash
docker-compose exec scheduler bash
```

## Variáveis de Ambiente

Configure no arquivo `.env`:

- `DB_HOST=db` (nome do serviço do container MySQL)
- `DB_CONNECTION=mysql`
- `QUEUE_CONNECTION=database`
- `CACHE_DRIVER=database`
- `SESSION_DRIVER=database`

## Troubleshooting

### Permissões de arquivo

Se encontrar erros de permissão, execute:

```bash
docker-compose exec app chown -R www-data:www-data /var/www
```

### Limpar cache e config

```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
```

### Reconstruir containers

```bash
docker-compose down
docker-compose up -d --build
```

## Ports

- **80**: Nginx (HTTP)
- **9000**: PHP-FPM
- **3306**: MySQL
- **9001**: Supervisor HTTP Server (internal only)

## Notes

- O container `scheduler` roda o Supervisor que gerencia o `laravel schedule:work` e `queue:work`
- Os logs do Supervisor estão em `docker/supervisor/logs/`
- Adicione mais programas ao Supervisor criando novos arquivos `.conf` em `docker/supervisor/conf.d/`
