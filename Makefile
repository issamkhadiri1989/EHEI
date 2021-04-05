PHP= ehei_php

stop:
	docker-compose stop
start:
	docker-compose up -d --no-recreate --remove-orphans
network-kill:
	docker network rm $$(docker network ls -q)
stop-containers:
	docker container stop $$(docker container ps -aq)
ini: stop stop-containers start
	docker-compose ps 
force-recreate:
	docker-compose up -d --force-recreate
force: stop force-recreate 
	docker-compose ps
enter: 
	docker exec -it $(PHP) bash
stan: 
	docker-compose exec phpstan phpstan analyse -c phpstan.neon $(file)
fixer: 
	docker-compose exec phpstan php-cs-fixer fix --dry-run --diff --diff-format=udiff $(file)