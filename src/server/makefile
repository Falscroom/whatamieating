# Makefile

# Variables
DOCKER_COMPOSE = docker compose
APP_SERVICE = app
DB_SERVICE = postgres

.PHONY: up down bash

# Start the Docker services
up:
	$(DOCKER_COMPOSE) up -d

# Stop and remove the Docker services
down:
	$(DOCKER_COMPOSE) down

# Access the bash shell inside the app container
bash:
	$(DOCKER_COMPOSE) exec $(APP_SERVICE) bash
