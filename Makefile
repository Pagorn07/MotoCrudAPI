.PHONY: init-project start stop

init-project:
	@echo "Initializing project..."
	docker-compose up -d --build
	@echo "Installing dependencies..."
	docker exec motocrudapi_php composer install
	@echo "Project initialized successfully"

start:
	@echo "Starting containers..."
	docker-compose up -d
	@echo "Starting server on http://localhost:8081"
	docker exec -d motocrudapi_php php -S 0.0.0.0:8000 -t public

stop:
	@echo "Stopping containers..."
	docker-compose down
	@echo "Containers stopped successfully"