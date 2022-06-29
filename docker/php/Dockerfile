FROM php:7.4-apache as builder

# Packages
RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        git \
        zlib1g-dev \
        libzip-dev \
        unzip \
        python \
        syslog-ng \
        wget \
        openjdk-17-jre \
        && ( \
            cd /tmp \
            && mkdir librdkafka \
            && cd librdkafka \
            && git clone https://github.com/edenhill/librdkafka.git . \
            && ./configure \
            && make \
            && make install \
        ) \
        && ( \
            cd /tmp \
            && mkdir confluent-hub \
            && cd confluent-hub \
            && wget http://client.hub.confluent.io/confluent-hub-client-latest.tar.gz \
            && tar -zxpvf confluent-hub-client-latest.tar.gz \
            && cd ..\
            && mv confluent-hub /opt \
        ) \
    && rm -r /var/lib/apt/lists/*

ENV PATH="/opt/confluent-hub/bin:${PATH}"

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) zip \
    && pecl install rdkafka-5.0.2 \
    && docker-php-ext-enable rdkafka \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# COMPOSER
COPY --from=composer:2.2 /usr/bin/composer /usr/local/bin/composer

# CREATE PHYSICAL ACCESS LOG FILE
RUN rm /var/log/apache2/access.log
RUN touch /var/log/apache2/access.log
RUN chown www-data.www-data /var/log/apache2/access.log
