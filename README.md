# Laravel server setup

## Prerequisites

- **[MySQL or alike, installed via a program such as XAMPP](https://www.apachefriends.org/)**
- **[PHP](https://www.php.net/downloads.php)**
- **[A tool to download dependencies with, for example Composer](https://getcomposer.org/download/)**

Download the repository, this can be done via the "code" options on this Github page. To link it for commits, use a URL found in the same options.

Run MySQL or any equivalent and make sure there's an existing database which is linked via its name in the environment configuration under the DB_DATABASE field, likely on line 14 in the Laravel setup's ".env" file (rename from ".env.example" to ".env" to apply the file)

## The following commands can be used to get started:

### Setup commands for the installation which are typically only runned once on new devices that have downloaded a repository using Laravel.
- composer update - download dependencies such as contents of the vendor folder
- php artisan key:generate - Create key obligatorily required by Laravel for more secure web browser cookie management
- php artisan migrate - Apply tables from "App\database\migrations" to the linked database, but the same migration files cannot be migrated again without a reset of the database

### Common commands used when working with Laravel
- php artisan serve - Run a local server
- php artisan migrate:fresh - Shortcut to execute the effects of "php artisan migrate:reset" followed by "php artisan migrate" to reapply migration files