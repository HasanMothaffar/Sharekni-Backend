# Sharekni

A REST API written in Laravel for a university project. It's a simple e-commerce app through which you can browse products that have an expiration date. Before the actual expiration date by a user-entered period of time, a discount will be applied to the product. Users can register an account on the platform and add their own products and contact information so that other users can contact them.

> This repository contains the backend logic for our app. The frontend is a Flutter app that is developed by other members of our team.

## Getting started

### Documentation

You can browse the online documentation in your browser or run it in Postman from this link:

https://documenter.getpostman.com/view/15694901/UVRAH6Xf

> I am planning to learn the OpenAPI 3.0 schema and update the docs according to it. Right now, I've written them by hand using Postman's collections, but there's no schema file for them.

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
-   Adding likes to products

The authentication and authorization parts are mainly handled by **Laravel Sanctum**
