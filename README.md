
# gardener-app

This is a Laravel API application called gardener for eden junior backend developer recruitment test. Built with Laravel 9

# Documentation

To view the full documentation **[Click here](https://documenter.getpostman.com/view/12234489/UVksLten)**

# FULL URL

<https://gardenerapi.herokuapp.com/>

# Requirements

 1. PHP >= 7.4
 2. composer
 3. Postman
 4. git
 5. mysql or postgres

# Features

1. Register a customers
2. Register a gardener
3. Get all the customers
4. Get all customers by their location
5. Get all the available locations
6. Get all the Gardeners
7. Get all gardeners by their country

## Extra Features

1. Unit Tests for Customer and Gardener
2. An error log handler
3. Caching for for all the GET request
4. You can add other things

## How to install

**To install this laravel application on your PC run the following command on your terminal or CMD**

```sh
git clone git@github.com:OfficialOzioma/gardener-app.git
```

```sh
cd gardener-app
```

```sh
composer install
```

- copy the .env.example file and rename it to .env
- add your database details on the .env file

```sh
php artisan migrate
```

```sh
php artisan db:seed
```

```sh
php artisan passport:install
```

```sh
php artisan serve
```
```sh
php artisan test
```

## API End points

For a complete documentation of this API visit the documentation page. **[Click here](https://documenter.getpostman.com/view/12234489/UVksLten)**

> ### Note: `API Bearer token is generated when a customer or gardener is registered` it is required for accessing other end points

| Details                | Method | API End points            |
| ---------------------- | ------ | ------------------------- |
| Register a customer               | POST   | [api/v1/customer/register](#) |
| Register a gardener                  | POST   | [api/v1/customer/register](#) |
| Get All Customers     | GET    | [api/v1/customers](#) |
| Find Customers by their Locations | GET | [api/v1/customers/{location}](#) |
| Get all Locations      | GET    | [api/v1/locations](#)     |
| Get all Gardeners      | GET | [api/v1/gardeners](#)     |
| Find Gardeners by their country    | GET   | [api/V1/gardeners/{country}](#) |

## License

MIT
