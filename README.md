# EveryWorkflow Server

A symfony based EveryWorkflow Server


Version: Under Development `dev-main`


## Env setup

#### Self hosted

```bash
# Install php and extensions
# Install symfony-cli
symfony serve
# Mongodb server need to be self hosted
```

#### Nix setup

```bash
mkdir ew && cd ew
git clone https://github.com/everyworkflow/backend.git
cd backend
# Nix .envrc setup everythings
bin/console
symfony serve
# Mongodb server need to be self hosted
```

#### Docker setup

- https://github.com/readymadehost/symfony-dev-docker

```bash
# Create new dir
mkdir everyworkflow
cd everyworkflow
# Clone symfony-dev-docker from https://github.com/readymadehost/symfony-dev-docker
git clone https://github.com/readymadehost/symfony-dev-docker
cd symfony-dev-docker
# Clone backend project
git clone https://github.com/everyworkflow/backend.git project
# Copy docker files for symfony-dev-docker
# Make sure docker is configured to use php8.2 and mongodb enabled in config
cp project/symfony-dev-docker/.env ./.env
cp project/symfony-dev-docker/docker-compose.yml ./docker-compose.yml
# Build containers
docker-compose build
# Spin up development containers
docker-compose up -d
# Check status of development containers
docker-compose ps
# Get inside cli container
docker-compose exec cli bash
# Everything is included
```


## Project setup

```bash
# Copy .env
cp .env.sample .env
# Install composer dependencies
composer install
# Generate JWT keypair
bin/console lexik:jwt:generate-keypair
# Drop database if exists
bin/console mongo:database:drop
# Migrate mongo migrations
bin/console mongo:migrate
# Sync mongo indexes
bin/console mongo:sync
# Manage project permission
mpp # /root/manage-project-permission.sh
```


## Seeder

```
bin/console mongo:seed "EveryWorkflow\AdminPanelBundle\Seeder\Mongo_2023_01_01_00_00_00_Basic_Seeder"
bin/console mongo:seed "EveryWorkflow\EcommerceBundle\Seeder\Mongo_2023_01_01_00_00_00_Ecommerce_Seeder"
```

```
bin/console mongo:seed:rollback -c "EveryWorkflow\AdminPanelBundle\Seeder\Mongo_2023_01_01_00_00_00_Basic_Seeder"
bin/console mongo:seed:rollback -c "EveryWorkflow\EcommerceBundle\Seeder\Mongo_2023_01_01_00_00_00_Ecommerce_Seeder"
```


## Swagger UI

- http://localhost:8080/swagger


## Tests

#### Running symfony tests

- `bin/console --env=test mongo:database:drop`
- `bin/console --env=test mongo:migrate`
- `bin/phpunit`

#### Generating code coverage

- `XDEBUG_MODE=coverage bin/phpunit --coverage-html public/test-html`
- Visit: http://localhost:8080/test-html/index.html


## Quick links

- https://symfony.com
- https://twig.symfony.com
- https://docs.mongodb.com/php-library
- https://carbon.nesbot.com

