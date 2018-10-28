# tank-game
## Must have before trying steps bellow:
* `docker` and `docker-compose`
## Steps to make the game functional:
* First clone the project `git clone https://github.com/AIFlorin/tank-game.git`
* Enter inside `/Development` folder;
* Run `docker-compose up --build`
* Run `docker-compose exec php sh` to enter the php container
* Run inside the php container `make install`

### API
Open the API manager (POSTMAN):
* Make a call to `POST http://localhost/api/battle_fields` that will give a `BattleField` id.
* Then make multiple calls to `PUT http://localhost/api/battle_fields/{id}/simulate` untill there will be no more turns.
* At `GET http://localhost/api` you can see all the available API's
