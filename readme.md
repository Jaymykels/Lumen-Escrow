# Simple Escrow Service with Lumen
A simple lumen application with a one to many model relationship implementation and database seeder with unit tests.


## Requirements

To be able to run this project one needs the following technologies:

- [Composer](https://getcomposer.org/)
- PHP
- MYSQL

## Installation

Following the instructions one should be able to run this project or at least have a good base how to start a Lumen project.

1. `git clone git@github.com:Jaymykels/Lumen-Escrow.git`
2. Rename `.env.example` file to `.env`. The
.env file is the environment file that deals with project configurations like database credentials, api keys, debug mode, application keys etc and this file is out of version control.
3. Set your application key to a random string. Typically, this string should be 32 characters long. In .env file it is called eg APP_KEY=akkfjvlakengoemvgkcgelapchyekci
4. Run `composer install` => to install all php dependencies. This will create a vendor folder which is the core lumen framework
5.  Inside `.env` file in the project root update `DB_HOST=mysql`
6. With a SQL tool as `Sequel Pro` or similar connect to the MySQL to create a new DB. Or use the Docker MySQL workspace bash to use commands instead.
7. Update database name and else in `.env`
8. Run `php artisan migrate:fresh --seed` to create tables in the database with dummy data.
9. Run `vendor\bin\phpunit` to run tests.
10. Run `php -S localhost:8000 -t public` to serve the application.

[Postman Collection](https://www.getpostman.com/collections/6f5301568b3dff2b97cf)

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
