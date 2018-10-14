# tank-game
## Must have before trying steps bellow:
* `docker` and `docker-compose`
## Steps to make the game functional:
* First clone the project `git clone https://github.com/AIFlorin/tank-game.git`
* Navigate to `/API` folder
* Run `composer install --ignore-platform-reqs`
* Enter inside `/Development` folder;
* Run `docker-compose up --build -d`
* Run `docker-compose exec php sh` to enter the php container
* Run inside the php container `php bin/console doctrine:database:create` to create the database tanks
* Run inside the php container `php bin/console doctrine:migrations:migrate -n` to run the database migrations
* Run inside the php container `php bin/console doctrine:fixtures:load -n` to initialize database with dummy data

### API
Open the API manager (POSTMAN):
* Make a call to `POST http://localhost/api/battle_fields` that will give a `BattleField` id.
* Then make multiple calls to `PUT http://localhost/api/battle_fields/{id}/simulate` untill there will be no more turns.
