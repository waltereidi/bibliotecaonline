buildup:
	docker-compose up -d --build
bash:
	docker exec -it laravel_app bash
bashdb:
	docker exec -it laravel_db bash

