FROM php:7.4-fpm

ARG UID=1000
ARG GID=1000
ARG USERNAME=www-data

RUN mkdir -p /home/$USERNAME  && chown $USERNAME:$USERNAME /home/$USERNAME \
    && usermod -u $UID $USERNAME -d /home/$USERNAME \
    && groupmod -g $GID $USERNAME \
    && chown $USERNAME:$USERNAME /var/www/html

RUN apt-get update && apt-get install -y \
      procps \
      nano \
      git \
      unzip \
      libicu-dev \
      zlib1g-dev \
      libxml2 \
      libxml2-dev \
      libreadline-dev \
      supervisor \
      cron \
      htop \
      libzip-dev \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install \
      pdo_mysql \
      sockets \
      intl \
      opcache \
      zip \
      pcntl \
    && rm -rf /tmp/* \
    && rm -rf /var/list/apt/* \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean


COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY --chown=$USERNAME:$USERNAME . /var/www/html

USER www-data

USER root

WORKDIR /var/www/html
