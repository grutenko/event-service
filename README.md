Построено на основе https://github.com/netojose/docker-lumen

## Установка

1. Установить Docker и Docker Compose
2. Клонировать и собрать проект.
    ```bash
    git clone https://github.com/grutenko/event-service
    cd event-service
    docker-compose build
    docker-compose up -d
    ```
3. Добавить тестовые данные
    ```bash
    docker exec -it eventservice_app_1 php artisan db:seed --force
    ```
---> _http://localhost:8080_

Документация: https://documenter.getpostman.com/view/11009239/T17M7Qza
