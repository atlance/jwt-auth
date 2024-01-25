docker-compose:
	envsubst < make/${APP_ENV}/infrastructure/docker-compose.yml > docker-compose.yml

docker-build:	## Buid dev images
	docker-compose build

docker-up:	## Start service.
	docker-compose up -d
