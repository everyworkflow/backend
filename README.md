# EveryWorkflow Platform

A symfony based every workflow platform


Version: Under Development `dev-main`


## Project setup

- Install symfony-dev-docker from https://github.com/readymadehost/symfony-dev-docker
- `git clone https://github.com/everyworkflow/everyworkflow-development.git project --recursive`
- `cd project && git submodule update --recursive --remote && cd ..` to update submodules
- For docker setup use: `cp project/symfony-dev-docker/.env ./.env`
- `cp project/symfony-dev-docker/docker-compose.yml ./docker-compose.yml`
- Make sure docker is configured to use php8.0 and mongodb enabled
- `docker-compose build` to build containers
- `docker-compose up -d` to spin up development containers
- `docker-compose ps` to check status of development containers
- `docker-compose exec cli bash` to get inside cli container
- `bin/console lexik:jwt:generate-keypair` to generate JWT keypair


## Symfony setup

- `docker-compose exec cli bash` to get inside cli container
- `composer install` to install composer dependencies
- `bin/console mongo:database:drop` to drop database
- `bin/console mongo:migrate` to migrate mongo migrations


## Swagger UI

- http://localhost:8080/swagger


## Tests

#### Running symfony tests

- `bin/console --env=test mongo:database:drop`
- `bin/console --env=test mongo:migrate`
- `vendor/bin/phpunit`

#### Running frontend tests

- `yarn test`

#### Generating code coverage

- `XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html public/test-html`
- Visit: http://localhost:8080/test-html/index.html


## Quick links

- https://symfony.com
- https://twig.symfony.com
- https://docs.mongodb.com/php-library
- https://carbon.nesbot.com
