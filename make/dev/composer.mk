composer-install:	## Install composer dependecies.
	docker-compose run --rm php-cli composer install --no-interaction --no-progress

composer-normalize:
	docker-compose run --rm php-cli composer normalize

composer-require:
	docker-compose run --rm php-cli composer req ${RUN_ARGS}
