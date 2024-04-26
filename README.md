# AI Music Recommendation System

## Preparation:
1. Download Docker from [Docker's official website](https://www.docker.com/products/docker-desktop/), then install and open the Docker app.

## Start the web application:
1. Open the terminal and run `docker compose up` to configure the runtime environment and launch the web application.
2. Wait for the application configuration to complete. You'll see a message like `[System] [MY-XXXXXX] [Server] /usr/sbin/mysqld: ready for connections. Version: 'X.X.X'  socket: '/var/run/mysqld/mysqld.sock'  port: 3306  MySQL Community Server - GPL`.
3. Open the browser and go to [http://localhost:4000/](http://localhost:4000/) to get started. Upon initial login to the application web page, the song information stored locally will be written into the database.


## To manage the database:
1. Once the application is launched, open a web browser and visit [http://localhost:8001/](http://localhost:8001/). Enter the credentials: username `admin` and password `secretpassword` to log in to phpMyAdmin. Then click on `song_recommendation_database` to view and manage song/user data.

## Close the web application:
1. To shut down the service, locate the terminal where the application is running and enter the interrupt command `control + c`.
2. (Optional) Run `docker compose down` in the terminal to delete the container.
