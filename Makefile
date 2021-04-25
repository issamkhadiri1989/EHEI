PHP = ehei_php
QA = phpstan

#stop all containers
stop:
	docker-compose stop

#start all container without recreate
start:
	docker-compose up -d --no-recreate --remove-orphans

#killing all networks
network-kill:
	docker network rm $$(docker network ls -q)

#stop containers
stop-containers:
	docker container stop $$(docker container ps -aq)

#start containers
restart: stop stop-containers start ls

#start with forcing
force-recreate:
	docker-compose up -d --force-recreate

#stop all containers and force recreate
force: stop force-recreate ls

#enter the php container
enter: 
	docker exec -it $(PHP) bash

#start phpstan analysis
stan: 
	docker-compose exec $(QA) phpstan analyse -c phpstan.neon $(file)

#start csfixer  analysis
fixer: 
	docker-compose exec $(QA) php-cs-fixer fix --dry-run --diff --diff-format=udiff $(file)

#stop containers
shutdown: stop stop-containers

#list all containers
ls:
	docker-compose ps

build:
	docker-compose build