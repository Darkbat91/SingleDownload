FROM php:apache
COPY . /var/www/html
RUN chown -R www-data: /var/www/html && \
    chmod -R 755 /var/www/html
