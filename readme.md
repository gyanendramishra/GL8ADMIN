# GL8ADMIN

## Installation

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm ci
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an Mysql database. You can also use another database (SqlLite, Postgres), simply update your configuration accordingly.

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Visit GL8ADMIN in your browser, and login with:

- **Username:** gyanendra.kumar@dotsquares.com
- **Password:** secret@12

## Running tests

To run the GL8ADMIN tests, run:

```
phpunit
```
