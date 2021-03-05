Command to run: 

# Create the tables
php bin/console doctrine:migrations:migrate

# Load products
php bin/console doctrine:fixtures:load


#to check the QA : 
- Fixer: docker-compose exec phpstan php-cs-fixer fix --dry-run --diff
- Stan: docker-compose exec phpstan phpstan analyse -c phpstan.neon 