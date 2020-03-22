## About

This project was developed for a job interview. [API Models](https://app.swaggerhub.com/apis/5.5.Degrees/the-laravel/1.0.0).

## Installation

- Copy .env.example and rename to .env
- RUN `composer install && php artisan key:generate && php artisan migrate && php artisan passport:install`
- Change `DB_HOST=127.0.0.1` to `DB_HOST=mysql` in .env
- RUN `docker-compose up`

## Test
You can download [Insomnia](https://insomnia.rest/) to test all API requests. There is a file 'Insomnia_API_TEST.json', you can import this file and test it.
- This project uses Laravel Passport for Auth. To test, you need to login and get the token response and put in the header. `Authorization: Bearer {token}`

## Auto Testing
To run the auto test you need run the command bellow:

`php artisan test`

## Docker RUN
To run the docker you need run the command bellow:

`docker-compose up`

## Technologies
- Laravel Framework 7.0.0
- PHP 7.4 (Arrow function)
- MariaDB 10.4
- Laravel Passport
- Docker
- PHP Unit
- Composer and Composer Test
