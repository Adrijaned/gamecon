# UPDATE
# docker pull php:7.3-apache && docker build --no-cache --tag jaroslavtyc/gamecon-7.3:latest .docker && docker push jaroslavtyc/gamecon-7.3:latest
# REBUILD (simply without --no-cache)
# docker pull php:7.3-apache && docker build --tag jaroslavtyc/gamecon-7.3:latest .docker && docker push jaroslavtyc/gamecon-7.3:latest

FROM php:7.3-apache AS gamecon-server-step1

RUN a2enmod rewrite expires && \
	# avoid warning on start
    echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# Install Linux libraries
RUN apt-get update && apt-get install -y --no-install-recommends \
      zlib1g-dev \
      libaio-dev \
      libxml2-dev \
      librabbitmq-dev \
      libyaml-0-2 libyaml-dev \
      libfreetype6-dev libjpeg62-turbo-dev \
      libgd-dev \
      libmagickwand-dev \
      mysql-common

FROM gamecon-server-step1 AS gamecon-tools-step2

# Install Linux tools
RUN apt-get update && apt-get install -y \
      mc \
      vim \
      # procps to get ps, top
      procps \
      curl \
      gnupg \
      git \
      sudo \
      iputils-ping \
      wget \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

FROM gamecon-tools-step2 AS gamecon-php-step3

RUN docker-php-ext-install mysqli pdo_mysql intl exif bcmath

# images support, like imagecreatefromjpeg()
RUN docker-php-ext-configure gd \
      --with-freetype-dir=/usr/include/ \
      --with-jpeg-dir=/usr/include/

RUN docker-php-ext-install gd \
    && php -r 'exit(function_exists("imagecreatefromjpeg") ? 0 : 1);'

# XDebug - to start it use docker compose
RUN pecl channel-update pecl.php.net \
    && yes | pecl install xdebug imagick \
    && docker-php-ext-enable imagick \
    && sed 's/<policy domain="coder" rights="none" pattern="PDF" \/>/<policy domain="coder" rights="read" pattern="PDF" \/>/' --in-place /etc/ImageMagick*/policy.xml

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

RUN echo 'alias ll="ls -al"' >> ~/.bashrc \
    && mkdir -p /var/log

RUN usermod --home /home/www-data --shell /bin/bash www-data \
    && mkdir -p /home/www-data \
    && chown -R www-data:www-data /home/www-data

USER www-data

RUN mkdir -p /home/www-data/bin \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/home/www-data/bin --filename=composer \
    && chmod +x /home/www-data/bin/composer \
  	&& echo 'export PATH="/home/www-data/bin:$PATH"' >> /home/www-data/.bashrc

RUN echo 'alias ll="ls -al"' >> /home/www-data/.bashrc

USER root

RUN echo 'alias ll="ls -al"' >> /root/.bashrc \
    && mkdir -p /var/log/php && chown -R www-data /var/log/php && chmod +w /var/log/php

FROM gamecon-php-step3 AS gamecon-project-step-final

# dot . reflects current dir, which is .docker
COPY . /.docker

RUN chmod +x /.docker/*.sh

ENV APACHE_DOCUMENT_ROOT=/var/www/html/gamecon
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

ENV ENV=local

WORKDIR $APACHE_DOCUMENT_ROOT

CMD bash /.docker/gamecon-run.sh $(pwd)