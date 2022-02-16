FROM php:8.1-apache-buster

WORKDIR /var/www/html

# install nodejs
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -

RUN apt-get update && apt-get install -y nodejs libzip-dev libpng-dev

RUN node --version

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# install php dependencies
RUN docker-php-ext-install mysqli gettext gd zip

COPY . .

RUN composer install

RUN npm install 

RUN npm run prod

RUN a2enmod rewrite