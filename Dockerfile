FROM registry.gitlab.com/medialabbiz/environment/php72-alpine:latest

# Maintainer information
LABEL maintainer="Zubenko Pavel <zubenkopavel@gmail.com>" 

COPY ./app /app/app
COPY ./app_old /app/app_old
COPY ./bootstrap /app/bootstrap
COPY ./config /app/config
COPY ./database /app/database
COPY ./public /app/public
COPY ./resources /app/resources
COPY ./routes /app/routes
COPY ./storage /app/storage
COPY ./tests /app/tests
COPY ./vendor /app/vendor
COPY ./.env /app/.env
COPY ./artisan /app/artisan
COPY ./composer.json /app/composer.json
COPY ./composer.lock /app/composer.lock
