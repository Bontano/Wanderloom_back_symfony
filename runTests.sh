clear
symfony console d:d:d --force --env=test
symfony console d:d:c --env=test
symfony console d:m:m --no-interaction --env=test
php bin/phpunit tests/itinary
