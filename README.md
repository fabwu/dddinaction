# DDD Snack Machine

This is a simple snack machine implemented in PHP and following the Domain Driven Design
principles. Everything is based on the Pluralsight course 
[Domain Driven Design in Practice](https://www.pluralsight.com/courses/domain-driven-design-in-practice)
by Vladimir Khorikov.

I couldn't implement everything exactly like Vladimir suggested it. Here is a list of 
things I had to adapt for the PHP language:

- I stored the snack machine with both money value types in the database. As a first 
approach I used sessions to overcome the state problem but this seems a bit like a overkill
so I stored everything in the database. Therefore, I have to read and save the snack machine
after each action but I couldn't come up with a better solution.
- I didn't have to break encapsulation or add new constructors because Doctrine discover
the properties via reflection and can create the proxies.
- I had to use annotations to describe the orm mapping. I don't really like them because they
clutter up my entities with persistence logic but the other options (xml, yml, php) don't provide
refactoring or auto-completion.
- Doctrine doesn't support entities on embeddables so I just use the id as an integer column.

I also tried to encapsulate the modules via [composer's path setting](https://getcomposer.org/doc/05-repositories.md#path). This was not useful
because it provides no encapsulation (e.g. Domain module can access UI module) and slows
down development.

## Installation

Run the following commands to install and start the server.
```
composer install
php bin/console doctrine:migrations:migrate
php -S localhost:8080 -t public/
```
You can then access the Snack Machine under http://localhost:8080

# Testing

Run the unit tests with the following command:
```
vendor/bin/phpunit --configuration phpunit.xml
```