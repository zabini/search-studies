ENV_FILE=.env

include $(ENV_FILE)

all: $(DOCKER_ENV)

long-wait:
	@echo "Take a long sleep... 20 sec"
	@sleep 20

short-wait:
	@echo "Take a short sleep... 5 sec"
	@sleep 5

migrate:
	docker container exec ecustos-ms-search-php php artisan migrate

rollback:
	docker container exec ecustos-ms-search-php php artisan migrate:rollback

seed:
	docker container exec ecustos-ms-search-php php artisan db:seed

app-key:
	docker container exec ecustos-ms-search-php php artisan key:generate

passport:
	docker container exec ecustos-ms-search-php php artisan passport:install --force

autoload:
	docker container exec ecustos-ms-search-php composer dump-autoload -o

install:
	composer install

up:
	docker-compose up -d

down:
	docker-compose down

down-v:
	docker-compose down -v

up-prod:
	docker-compose -f docker-compose.prod.yml up -d

down-prod:
	docker-compose -f docker-compose.prod.yml down

cache:
	docker container exec ecustos-ms-search-php php artisan config:cache
	docker container exec ecustos-ms-search-php php artisan route:cache

image:
	docker-compose build

image-push:
	docker-compose push

image-pull:
	docker-compose -f docker-compose.prod.yml pull

prod-pull:
	git pull origin master

staging-pull:
	git pull origin staging

prod-checkout:
	git checkout master

staging-checkout:
	git checkout staging

deploy: $(DOCKER_ENV)-checkout $(DOCKER_ENV)-pull image image-push

dev: image up app-key long-wait migrate short-wait seed

staging: down-prod staging-checkout staging-pull image-pull up-prod cache

prod: down-prod prod-checkout prod-pull image-pull up-prod cache

