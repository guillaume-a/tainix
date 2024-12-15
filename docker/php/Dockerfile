FROM php:8.3.14-cli-alpine

COPY --from=composer/composer:2-bin /composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app

#VOLUME /app/var/

#RUN apt-get update && apt-get install -y --no-install-recommends \
#	acl \
#	file \
#	gettext \
#	git \
#	&& rm -rf /var/lib/apt/lists/*

RUN apk add --no-cache \
      libzip-dev \
      zip \
      linux-headers \
      $PHPIZE_DEPS \
    ;

#apk add --no-cache --update --virtual buildDeps autoconf \
RUN docker-php-ext-install \
#		@composer \
#		apcu \
#		intl \
#		opcache \
		zip \
	;



#ENV PHP_INI_SCAN_DIR=":$PHP_INI_DIR/app.conf.d"

#RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN pecl install xdebug-3.4.0

RUN docker-php-ext-enable xdebug

#COPY --link ./20-xdebug.ini $PHP_INI_DIR/app.conf.d/
