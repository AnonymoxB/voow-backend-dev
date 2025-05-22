# Voow API

API Backend Project Voow

## Requirements

### PHP
- Recomended PHP version ^8.1

### Composer
- Recomended Composer version ^2.0

### Database
- Mysql

## Installation & Update

Install php dependencies
``` bash
composer install
```

Make .env
```bash
cp .env.example .env
```

Generate app key
```bash
php artisan key:generate
```

Configure DB on .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_voow
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations
```bash
php artisan migrate
```

Create symbolic link from public/storage to storage/app/public
```bash
php artisan storage:link
```

### For development purpose (Optional)

Run fresh migrations with seeds
```bash
php artisan migrate:fresh --seed
```

### This step is required in every deployment

Run migrations
```bash
php artisan migrate
```

Sync versioning on .env
```bash
APP_VERSION=x.x.x
```

Clear/optimize system
```bash
php artisan optimize:clear
```

## Run Server

Run server
```bash
php artisan serve
```
