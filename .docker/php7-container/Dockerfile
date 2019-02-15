FROM php:7.2-fpm-alpine
MAINTAINER PS ANONYM

WORKDIR /var/www/app

RUN apk update

# PHPIZE_DEPS = autoconf dpkg-dev dpkg file g++ gcc libc-dev make pkgconf re2c
RUN apk add --no-cache $PHPIZE_DEPS \
	curl \
	vim

### Change time zone
RUN apk add tzdata
RUN cp /usr/share/zoneinfo/Europe/Vilnius /etc/localtime
RUN echo "Europe/Vilnius" > /etc/timezone

### INSTALL AND CONFIURE EXTENSIONS
RUN docker-php-ext-install \
	pdo_mysql \
	opcache

RUN pecl install xdebug && docker-php-ext-enable xdebug

#igbinary
RUN curl -L -o /tmp/igbinary.tar.gz "https://github.com/igbinary/igbinary/releases/download/2.0.7/igbinary-2.0.7.tgz" \
    && mkdir -p /usr/src/php/ext/igbinary \
    && tar -C /usr/src/php/ext/igbinary -zxvf /tmp/igbinary.tar.gz --strip-components=1 \
    && docker-php-ext-install igbinary \
    && rm /tmp/igbinary.tar.gz

#redis
RUN curl -L -o /tmp/redis.tar.gz "https://github.com/phpredis/phpredis/archive/4.1.1.tar.gz" \
    && mkdir -p /usr/src/php/ext/redis \
    && tar -C /usr/src/php/ext/redis -zxvf /tmp/redis.tar.gz --strip-components=1 \
    && docker-php-ext-configure redis --enable-redis-igbinary \
    && docker-php-ext-install redis \
    && rm /tmp/redis.tar.gz

#Move configs
COPY configs/php.ini /usr/local/etc/php/php.ini
COPY configs/opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini
COPY configs/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
### EOF OF INSTALL AND CONFIGURE EXTENSIONS

#Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/bin/composer

CMD ["php-fpm"]