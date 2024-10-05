compose-up:
	docker-compose up -d --build

serve:
	composer run serve

dump:
	composer dump-autoload

migrate:
	composer run migrate
