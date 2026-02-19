# Utilisation de l'image Apache avec PHP 8.2
FROM php:8.2-apache

# 1. Installation des extensions PHP nécessaires (si ton app grandit)
# On ajoute souvent pdo_mysql pour la base de données
RUN docker-php-ext-install pdo_mysql

# 2. Activation du module Rewrite d'Apache (très utile pour les routes PHP)
RUN a2enmod rewrite

# 3. Copie de ton code source dans le dossier par défaut d'Apache
# Note : Si ton code est dans un dossier 'src/', on copie son CONTENU
COPY src/ /var/www/html/

# 4. Ajustement des permissions (évite les erreurs d'écriture de fichiers)
RUN chown -R www-data:www-data /var/www/html

# Le port 80 est exposé par défaut par l'image php:apache
EXPOSE 80

# Pas besoin de CMD, l'image parente lance déjà Apache automatiquement