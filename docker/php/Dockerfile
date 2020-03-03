FROM php:7.4-fpm-alpine

# Change User-ID of www-data
RUN apk add --no-cache --update shadow \
 && usermod -u 1000 www-data \
 && groupmod -g 1000 www-data

# Install Extensions
RUN docker-php-source extract \
 && docker-php-ext-configure opcache mbstring \
 && docker-php-ext-install opcache mbstring \
 && docker-php-source delete

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
 && php composer-setup.php \
 && php -r "unlink('composer-setup.php');" \
 && mv composer.phar /usr/local/bin/composer \
 && composer self-update

COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./ /app/

WORKDIR /app

RUN chown -R www-data:www-data /app
USER www-data
RUN composer install
USER root
