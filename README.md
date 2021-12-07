# Sharekni - WIP

> This repository contains the backend logic for our app. The frontend is a Flutter app that will later be developed by other members of our team.

> This is work in progress document. I will be regularly updating it as we progress through the project

## Getting started

### Installation

1. Clone the repository and run

```sh
composer install
```

2. Contact me to send you a copy of the `.env` file, which contains the app's configuration.

3. Run the app's migrations and, if available, run the Database' seeders

```sh
php artisan migrate

#If seeds are available
php artisan db:seed
```

### Database

The app's data is stored in a MYSQL database. You can configure it from the `.env` file.

### Debugging

Note that in the .env file, there's a field called `APP_DEBUG` that is set to `true` by default. Only set it to `false` if you want to mock a production environment.

## Goals

This app demonstrates our understanding of REST APIS through some basic features:

-   CRUD operations on the products resource
-   Registration - Logging in - Logging out

The authentication and authorization parts are mainly handled by **Laravel Sanctum**

## TODO

Read more about throttling (login throttling in the authentication docs laravel)

- Learn about Laravel's authorization policies in order to ensure that users can only delete records that they have entered.
- Figure out whether the project requires the 'like' or 'wishlist' functionality.
- Refactor database model relationships.
