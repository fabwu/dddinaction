# DDD Snack Machine

[![Build Status](https://travis-ci.com/fabwu/dddinaction.svg?branch=module-7)](https://travis-ci.com/fabwu/dddinaction)

This is a simple snack machine implemented in PHP and following the Domain Driven Design
principles. Everything is based on the Pluralsight course 
[Domain Driven Design in Practice](https://www.pluralsight.com/courses/domain-driven-design-in-practice).
You can find the original C# source code [here](https://github.com/vkhorikov/DddInAction).

The repository contains the following branches each reflecting a module in the course:

- `module-2` Starting with the First Bounded Context
- `module-3` Introducing UI and Persistence Layers
- `module-5` Extending the Bounded Context with Aggregates & Introducing Repositories
- `module-6` Introducing the Second Bounded Context
- `module-7` Working with Domain Events

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
- The domain events implementation is inspired from [this blogpost](https://beberlei.de/2013/07/24/doctrine_and_domainevents.html).
I tried to use a more type save approach but it's still ugly due to the php type system. You also have
to register all domain events handler manually. A compiler pass collects all tagged handlers and adds them
to the dispatcher.

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
You can then access the application under http://localhost:8080

# Testing

Run the tests with the following command:
```
# Unit Tests
vendor/bin/phpunit --configuration phpunit.xml --testsuite unit

# Integration Tests
vendor/bin/phpunit --configuration phpunit.xml --testsuite integration
```