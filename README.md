# files-cli

This little project runs inside a Docker 
container with a php image

starting the container

`docker-compose up -d`

going in the app container:

`docker exec -it app bash`

from command line:

`php bin/app.php` - list all available commands

cli.save, cli.delete, cli.get

there is a `start.sh` script that will start the container and go in it
and another one `stop.sh` to stop it

`test.sh` should run unit tests