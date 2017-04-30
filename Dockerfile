FROM node:7 as node
FROM eboraas/laravel

COPY --from=node /usr/local/bin/yarn /usr/local/bin/yarn
COPY --from=node /usr/local/bin/node /usr/local/bin/node

COPY ./ /var/www/laravel
WORKDIR /var/www/laravel

RUN composer install
RUN php artisan kupo:init

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0
