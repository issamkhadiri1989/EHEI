**Example of using security and Image constraint**


- Install the project: *composer install*

- Edit the file .env to point to the right host, db name and credentials

- Install the tables with : *php bin/console doctrine:migrations:migrate*

- Loading the users: *php bin/console doctrine:fixtures:load*

- Enjoy !

- The file db_name.sql is a dump of an example database. 

