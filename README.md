# Synaptik-PHP-test

Тестовое задание PHP+Laravel+Vue

## Установка

Чтобы все заработало, необходимо наличие:
- PHP >=7.2.5
- npm
- nodejs
- composer
- curl

Следующая пачка команд делает хорошо
```
git clone https://github.com/Nealbow/php-test.git
cd php-test
npm i
composer i
npm run prod
```
*Далее* нужно создать файл `.env` и скопировать в него содержимое `.env.example`
После выполнить еще немного
```
php artisan key:generate
php artisan serve
```


Сервер будет развернут по адресу `localhost:8000`
API находится по адресу `localhost:8000/api`
Вызываемый эндпоинт находится по адресу `localhost:8000/api/trades`

Если для CURL не установлен сертификат, возможна ошибка получения списка для таблицы.
