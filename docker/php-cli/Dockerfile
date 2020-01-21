ARG PHP_VERSION

FROM php:${PHP_VERSION}-cli

# Set Environment Variables
ENV DEBIAN_FRONTEND noninteractive

RUN set -xe; \
    apt-get update -yqq && \
    pecl channel-update pecl.php.net && \

    apt-get install -yqq \
      apt-utils \
      supervisor \
      procps \
      sudo \
      wget \
      nano \
      netcat \
      inetutils-ping \
      libzip-dev zip unzip && \
      docker-php-ext-install zip && \
      curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Unfortunately, bcmath still required by graphaware's php-bolt client
RUN docker-php-ext-install bcmath

RUN  mkdir /php && chown -R www-data:www-data /php
RUN chown www-data:www-data /var/www/

WORKDIR /php

COPY startup.sh /startup.sh

CMD ["/bin/bash","/startup.sh"]