# syntax=docker/dockerfile:experimental
ARG php_cli_image
FROM $php_cli_image AS php-common

ARG pear_ext_dir_date
ENV PHP_EXT_DIR "/usr/local/lib/php/extensions/no-debug-non-zts-$pear_ext_dir_date"
RUN set -ex \
    && if [ `pear config-get ext_dir` != ${PHP_EXT_DIR} ]; then echo PHP_EXT_DIR must be `pear config-get ext_dir` && exit 1; fi

FROM php-common AS php-build
RUN --mount=type=cache,target=/var/cache/apk set -ex \
    && apk add --update-cache $PHPIZE_DEPS

FROM php-build AS php-ext-intl
RUN --mount=type=cache,target=/var/cache/apk set -ex \
    && apk add \
        icu-dev \
	&& docker-php-ext-install intl

FROM php-build AS php-ext-xdebug
RUN set -ex \
    && apk add --update linux-headers \
	&& pecl install xdebug

FROM php-build AS php-ext-pcntl
RUN set -ex \
    && docker-php-ext-install pcntl

FROM php-common AS php-base
COPY --from=php-ext-intl ${PHP_EXT_DIR}/intl.so       ${PHP_EXT_DIR}/
COPY --from=php-ext-intl /usr/local                   /usr/local
COPY --from=php-ext-pcntl ${PHP_EXT_DIR}/pcntl.so     ${PHP_EXT_DIR}/
COPY --from=php-ext-xdebug ${PHP_EXT_DIR}/xdebug.so   ${PHP_EXT_DIR}/
RUN --mount=type=cache,target=/var/cache/apk \
    set -ex \
    && apk add libpq icu shadow gettext git \
    && docker-php-ext-enable intl pcntl xdebug \
    && mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./php-cli/conf.d /usr/local/etc/php/conf.d

ARG user
ARG uid

RUN addgroup $user \
    && adduser -DS -h /home/$user -u 1000 -G $user $user \
    && adduser www-data $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

COPY --chown=$user:$user --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER $user:$user

ARG app_dir
WORKDIR $app_dir
