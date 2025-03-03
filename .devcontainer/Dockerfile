FROM mcr.microsoft.com/devcontainers/base:ubuntu-24.04

# use this Dockerfile to install additional tools you might need, e.g.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>
RUN apt update \
    && apt install -y \
    imagemagick \
    openssl \
    redis-server \
    php-cli \
    php-fpm \
    php-bcmath \
    php-common \
    php-curl \
    php-dev \
    php-gd \
    php-intl \
    php-mbstring \
    php-mysqli \
    php-phar \
    php-pspell \
    php-redis \
    php-xdebug \
    php-xml \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');"
