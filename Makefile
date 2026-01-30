.PHONY: init-project start stop

init-project:
	@echo "Initializing project..."
	docker-compose up -d --build
	@echo "Installing dependencies..."
	docker exec motocrudapi_php composer install
	@echo "Project initialized successfully"

update-database-schema:
	@echo "Creating database..."
	@docker exec motocrudapi_php php bin/console doctrine:database:create --if-not-exists
	@echo "Running migrations..."
	@docker exec motocrudapi_php php bin/console doctrine:migrations:migrate --no-interaction
	@echo "Database schema updated successfully"

load-fixtures-data:
	@echo "Loading fixtures data..."
	@docker exec motocrudapi_php php bin/console doctrine:fixtures:load --no-interaction
	@echo "Fixtures loaded successfully"

start:
	@echo "Starting containers..."
	docker-compose up -d
	@echo "Starting server on http://localhost:8081"
	docker exec -d motocrudapi_php php -S 0.0.0.0:8000 -t public

stop:
	@echo "Stopping containers..."
	docker-compose down
	@echo "Containers stopped successfully"