Развернуть сервис можно двумя способами.
 1) Локальный сервер - положить содержимое каталога в www каталог вашего веб сервера, а так же импортировать дамп базы данных.
 2) Докер (на нем я разрабатывал) - перейти в корневой каталог сервиса и выполнить поочередно: 
`docker-compose build`,`docker-compose up -d`. После поднятия контейнеров необходимо импортировать дамп базы. Для остановки контейнеров `docker-compose down`
 3) Настройки приложения лежил в корневом каталоге , а файле `.env`
 4) Так необходимо установить все зависимости композера