FROM php:apache
RUN apt-get update
RUN apt-get upgrade -y
RUN apt-get install -y openssl libssl-dev libcurl4-openssl-dev git
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install curl
RUN apt-get install -y sendmail sendmail-bin
RUN pecl install msgpack
RUN a2enmod rewrite
copy ./run.sh /
copy ./html /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
RUN rm /usr/local/bin/composer
RUN rm composer.json
RUN rm composer.lock
RUN chown -R www-data:www-data /var/www/html
RUN chmod +X /run.sh
RUN chmod 775 /run.sh
RUN mkdir /tmp/php/
RUN mkdir /tmp/php/sessions/
RUN mkdir /tmp/php/uploads/
RUN chmod -R 777 /tmp/
RUN sed -i -e 's/\r$//' /run.sh
ENTRYPOINT /run.sh