# 🎵 Emotional-aware Musical Recommendation System

<br>

### _"Unlock Your Soundtrack: Where Lyrics, Genres, and AI Unite for Your Prefect Groove."_

<br>

## 📖 Introduction
Welcome to the **Emotional-aware Musical Recommendation System**, a project designed to enhance your music discovery experience using artificial intelligence. The system analyzes your preferences and recommends songs that match your unique taste.

<br>

## ✨ Features:
- AI-powered song recommendations based on user preferences
- Simple, user-friendly web interface
- Docker-based setup for seamless deployment and management
- Easy-to-manage MySQL database with a built-in admin interface - phpMyAdmin

<br>

## 🚀 Launch Guidelines:

> ### Prerequisites
- Download and install Docker from [Docker's official website](https://www.docker.com/products/docker-desktop/).
- Make sure Docker is running on your system.

> ### Setup Instructions

1. Open the terminal and navigate to the project's root directory.
2. Run the following command to configure the runtime environment and launch the web application:
   ```bash
   docker compose up
   ```
3. Wait for the configuration to complete. You'll see a message in the following form when the server is ready:
   ```
   [System] [MY-XXXXXX] [Server] /usr/sbin/mysqld: ready for connections. Version: 'X.X.X'  socket: '/var/run/mysqld/mysqld.sock'  port: 3306  MySQL Community Server - GPL.
   ```
4. Open your web browser and visit [http://localhost:4000/](http://localhost:4000/) to access the application. On the initial login, extra time is needed to load the song information into the database.

> ### Database Management Instructions
1. Once the application is running, open your web browser and visit [http://localhost:8001/](http://localhost:8001/).
2. Use the following credentials to log into phpMyAdmin:
   - **Username:** admin
   - **Password:** secretpassword
3. Select the **song_recommendation_database** to manage song and user data.

> ### Shutdown Instructions

1. In the terminal where the application is running, press `Ctrl + C` to stop the service.
2. (Optional) To completely remove the container, run:
   ```bash
   docker compose down
   ```

<br>

## 🧩 Tech Stack:
- Machine Learning: PyTorch, pandas, NumPy
- Deployment: Docker, Docker Compose
- Backend: Python (Flask), MySQL
- Frontend: HTML, CSS, JavaScript
- Database Management: phpMyAdmin

<br>

## 📄 License:
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
