# DDD Snack Machine

This is a simple snack machine implemented in PHP and following the Domain Driven Design
principles. Everything is based on the Pluralsight course 
[Domain Driven Design in Practice](https://www.pluralsight.com/courses/domain-driven-design-in-practice)
by Vladimir Khorikov.

I tried to encapsulate the modules via [composer's path setting](https://getcomposer.org/doc/05-repositories.md#path). This was not useful
because it provides no encapsulation (e.g. Domain module can access UI module) and slows
down development.

## Installation

Run the following commands to install and start the server.
```
composer install
php -S localhost:8080 -t public/
```
You can then access the Snack Machine under http://localhost:8080

# Testing

Run the unit tests with the following command:
```
vendor/bin/phpunit --configuration phpunit.xml
```