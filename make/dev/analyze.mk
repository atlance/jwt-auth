php-analyze:	## Run static analyze - phpcs, phplint, phpstan, psalm.
	docker-compose run --rm php-cli composer php-analyze

php-cs-fix:
	docker-compose run --rm php-cli composer cs-fix
