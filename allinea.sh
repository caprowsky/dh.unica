#!/bin/bash

echo "Eseguo docker-compose down\n\n\n"
docker-compose down
sleep 1
echo "Copio l'ultimo database...\n\n\n"

rm mariadb-init/backup.sql

scp dhwp@90.147.144.144:/home/dhwp/dump-db/backup.sql mariadb-init/backup.sql

echo "\nAssicurati di aver committato eventuali modifiche perché tra 10 secondi farò switch su master"
sleep 5

echo "\n Ancora 5 secondi ed eseguo lo switch"

git fetch --all
git checkout master
sleep 3

echo "Eseguo il git pull"

git pull origin master

echo "faccio partire tutti i container in locale"
./dev.sh up
echo "Aspetto 1 minuto perché sto importando il db di produzione"
sleep 60
echo "Imposto wordpress per lo sviluppo locale"
# wp plugin deactivate really-simple-ssl
# wp option update home 'http://dh.unica.localhost'
# wp option update siteurl 'http://dh.unica.localhost'

wp search-replace --url=dh.unica.it dh.unica.it dh.unica.localhost 'wp_*options' wp_blogs


echo "resetto la passowrd di admin in admin, mentre tutte le altre rimangono le stesse"

wp user update 1 --user_pass=admin




echo "Finito!"