
# Utilise l'image officielle PHP 8.2 CLI comme base
FROM php:8.2-cli



# 1. Dépendances système (essentielles uniquement)
RUN apt-get update \
    && apt-get install -y gnupg2 wget git unzip libzip-dev libpng-dev libonig-dev libxml2-dev libicu-dev libpq-dev libsqlite3-dev

# 2. Extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql intl zip

# 3. Symfony CLI (méthode alternative via curl)
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# 4. Composer
RUN wget https://getcomposer.org/installer -O composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Copie le reste de la configuration (optionnel)
# USER vscode
