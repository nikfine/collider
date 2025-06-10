## Разворачивание проекта
- docker-compose up -d --build
- docker exec -ti app sh -c "composer install"
- docker exec -ti app sh -c "php yii migrate"

## Тестирование проекта
- docker exec -ti app sh -c "vendor/codeception/codeception/codecept run unit"
- docker exec -ti app sh -c "vendor/bin/phpstan analyse"

## Тестирование из Postman
- Из таблицы users взять токен
- Авторизация Basic Auth