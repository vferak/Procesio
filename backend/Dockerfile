FROM php:8.0-apache-buster

WORKDIR /var/www

ARG USER_ID
ARG GROUP_ID

RUN usermod -u ${USER_ID:-1000} www-data
RUN groupmod -g ${GROUP_ID:-1000} www-data

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get -y update

#configure apache
RUN a2enmod rewrite
COPY backend/docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

#php-ext mysqli
RUN docker-php-ext-install mysqli pdo pdo_mysql

#php-ext zip
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-configure zip \
  && docker-php-ext-install zip

#php-ext intl
RUN apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

#php-ext gd
RUN apt-get install -y libpng-dev \
    && docker-php-ext-install gd

#php-ext sysvsem
RUN docker-php-ext-install sysvsem

#php-ext xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

USER www-data
