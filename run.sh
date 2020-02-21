#!/bin/bash
php /var/www/html/index.php docker-setup
chown -R www-data:www-data /var/www/ 
/etc/init.d/sendmail start
/usr/sbin/apache2ctl -D FOREGROUND