FROM php:7.2.10

RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    libxml2-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    libjpeg62-turbo-dev \
    zlib1g-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) iconv soap intl gd pdo pdo_pgsql

RUN rm -r /var/lib/apt/lists/*

ARG UID=1000
ARG GID

RUN usermod -u ${UID} www-data

ENTRYPOINT ["php", "yii"]
