# Lehati

## System Requirements

1. PHP 8.2+.
2. Composer (latest version).
3. Node.js 22+.
4. Database (MySQL/PostgreSQL/SQLite).

## Installation Steps

### 1. Pindah folder apps
```sh
cd apps
```

### 2. Instal Dependensi Composer
```sh
composer install 
```

### 3. Instal Dependensi NPM
```sh
npm install
```

### 4. Copy Env file
```sh
cp .env.example .env
```

### 5. Artisan Run 
```sh
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
```

### 6. Runing Development
```sh
composer run dev
```