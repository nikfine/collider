## Разворачивание проекта
- docker-compose up -d --build
- docker exec -ti app sh -c "composer install"
- docker exec -ti app sh -c "php yii migrate"
- docker exec -ti app sh -c "php yii seed"

## API
- POST /event
- GET /events?page={page}&limit={limit}
- DELETE /events?before={datetime}
- GET /users/{user_id}/events
- GET /stats?from={datetime}&to={datetime}&type={type_id}

## Консоль
- docker exec -ti app sh -c "php yii seed" - создание тестовых данных
- docker exec -ti app sh -c "php yii seed/flush" - очистка тестовых данных