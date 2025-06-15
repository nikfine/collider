## Разворачивание проекта
- docker-compose up -d --build
- docker exec -ti app sh -c "composer install"
- docker exec -it app chown -R application:application /var/www/html/runtime
- docker exec -it app chmod -R 775 /var/www/html/runtime
- docker exec -ti app sh -c "php yii migrate"
- docker exec -ti app sh -c "php yii seed"

## API
- POST /event
- GET /events?page={page}&limit={limit}
- DELETE /events?before={datetime}
- GET /users/{user_id}/events
- GET /stats?from={datetime}&to={datetime}&type={type}

## Консоль
- docker exec -ti app sh -c "php yii seed" - создание тестовых данных
- docker exec -ti app sh -c "php yii seed/flush" - очистка тестовых данных