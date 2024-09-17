#!/bin/bash
rsync -rlvzu --chown=www-data:www-data --chmod=775 --exclude='.git/' -e ssh . gitlab-runner@192.168.0.125:/var/www/sicav;

echo 'Iniciando composer install... \n '

ssh root@192.168.0.125 "cd /var/www/sicav && php8.2 /usr/local/bin/composer install && chown -R gitlab-runner . && chmod -R g+w .";
