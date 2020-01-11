#!/bin/bash
php /var/www/html/index.php docker-setup
/etc/init.d/sendmail start
/usr/sbin/apache2ctl -D FOREGROUND