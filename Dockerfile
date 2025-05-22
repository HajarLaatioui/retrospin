# Utiliser l'image officielle PHP 8.1 avec Apache
FROM php:8.2-apache

# Installer les extensions PHP nécessaires (pdo_mysql, intl, zip, etc.)
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install intl pdo_mysql zip

# Activer le module Apache rewrite (utile pour Symfony)
RUN a2enmod rewrite

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le code de l'application dans le dossier webroot d'Apache
COPY . /var/www/html/

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer les dépendances PHP via Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Donner les droits nécessaires au cache et logs Symfony
RUN chown -R www-data:www-data var/cache var/log

# Exposer le port 80 (HTTP)
EXPOSE 80

# Commande par défaut pour lancer Apache en mode foreground
CMD ["apache2-foreground"]


