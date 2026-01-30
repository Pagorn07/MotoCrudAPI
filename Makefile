.PHONY: init-project start stop update-database-schema load-fixtures-data clean clean-all logs shell-php shell-db

init-project:
	@echo "Initializing project..."
	@docker compose up -d --build
	@echo "Installing dependencies..."
	@docker exec motocrudapi_php composer install
	@echo "Project initialized successfully"

update-database-schema:
	@echo "Creating database..."
	@docker exec motocrudapi_php php bin/console doctrine:database:create --if-not-exists
	@echo "Running migrations..."
	@docker exec motocrudapi_php php bin/console doctrine:migrations:migrate --no-interaction
	@echo "Setting up test database..."
	@docker exec motocrudapi_db mysql -u root -proot -e "CREATE DATABASE IF NOT EXISTS motocrudapi_test;"
	@docker exec motocrudapi_db mysql -u root -proot -e "GRANT ALL PRIVILEGES ON motocrudapi_test.* TO 'user'@'%'; FLUSH PRIVILEGES;"
	@docker exec motocrudapi_php php bin/console doctrine:migrations:migrate --env=test --no-interaction
	@echo "Database schema updated successfully"

load-fixtures-data:
	@echo "Loading fixtures data..."
	@docker exec motocrudapi_php php bin/console doctrine:fixtures:load --no-interaction
	@echo "Fixtures loaded successfully"

start:
	@echo "Starting containers..."
	@docker compose up -d
	@echo "Starting server on http://localhost:8081"
	@docker exec -d motocrudapi_php php -S 0.0.0.0:8000 -t public

stop:
	@echo "Stopping containers..."
	@docker compose down
	@echo "Containers stopped successfully"

clean:
	@echo "Stopping and removing containers..."
	@docker compose down
	@echo "Containers removed successfully"

clean-all:
	@echo "Stopping and removing containers, volumes and images..."
	@docker compose down -v --rmi local
	@echo "Project cleaned completely"

logs:
	@docker compose logs -f

shell-php:
	@docker exec -it motocrudapi_php bash

shell-db:
	@docker exec -it motocrudapi_db mysql -u user -p