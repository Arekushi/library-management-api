compose-up:
	docker-compose up -d --build

serve:
	composer run serve

dump:
	composer dump-autoload

migrate:
	php bin/migrate.php

rollback:
	php bin/rollback.php
