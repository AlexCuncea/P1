# Utilizează o imagine oficială de Apache și PHP
FROM php:8.0-apache

# Instalare extensii necesare pentru PDO și MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copierea codului aplicației în container
COPY . /var/www/html/

# Expunerea portului 80
EXPOSE 80

FROM php:8.0-apache

# Instalează extensia mysqli
RUN docker-php-ext-install mysqli

# Copiază conținutul directorului curent în container
COPY . /var/www/html/
