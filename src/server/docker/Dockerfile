FROM php:8.2-fpm

# Обновляем пакеты и устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    wget \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl pdo_pgsql zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && npm install -g yarn \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Создаем директории и настраиваем права
#RUN mkdir -p /var/www/downloads \
#    && chown -R www-data:www-data /var/www/downloads \
#    && ls -la /var/www

# Копируем конфигурационные файлы
COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./docker/php/docker-php-ext-opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

# Копируем Composer из официального образа
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем скрипт entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Даем права на выполнение скрипта entrypoint
RUN chmod +x /usr/local/bin/entrypoint.sh

# Настройка для отладки
ENV PHP_IDE_CONFIG="serverName=localhost"

# Устанавливаем рабочую директорию
WORKDIR /var/www

# Открываем порт
EXPOSE 8000

# Настройка точки входа
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
