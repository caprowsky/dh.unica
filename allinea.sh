#!/bin/bash
echo -e "Sto avviando la procedura di startup dell'ambiente locale con la copia \n dell'ultimo database disponibile dall'ambiente remoto \n\n\n"
echo -e "Assicurati di aver abilitato la vpn verso la rete interna di unica.it  \n\n\n"

sleep 3

echo -e "Eseguo docker-compose down \n\n\n"
docker-compose down
sleep 1
echo -e "Importo l'ultimo database da produzione \n\n\n"

rm mariadb-init/backup.sql

scp dhwp@90.147.144.144:/home/dhwp/dump-db/backup.sql mariadb-init/backup.sql

echo -e "\nAssicurati di aver committato eventuali modifiche perché tra 10 secondi farò switch su master"
sleep 5

echo "\n Ancora 5 secondi ed eseguo lo switch"

git fetch --all
git checkout master
sleep 3

echo -e "Eseguo il git pull\n\n"

git pull origin master

echo -e "Faccio ripartire tutti i container in locale \n\n"

./dev.sh up

echo -e "Aspetto 1 minuto perché sto importando il db di produzione \n\n"
sleep 2
echo -e "In caso di errore è sufficente aumentare il tempo di attesa dell'importazione \n\n"
sleep 60
echo -e "Ok db importato \n\n"
sleep 2
echo -e "Imposto wordpress per lo sviluppo locale\n\n"

# Posso inserire qui i plugin da disabilitare
# wp plugin deactivate really-simple-ssl
# wp option update home 'http://dh.unica.localhost'
# wp option update siteurl 'http://dh.unica.localhost'

wp search-replace --url=dh.unica.it dh.unica.it dh.unica.localhost 'wp_*options' wp_blogs

echo -e "Resetto la passowrd di admin in admin, mentre tutte le altre rimangono le stesse \n\n"

wp user update 1 --user_pass=admin

echo -e "Procedura completata. Vai all'indirizzo http://dh.unica.localhst \n"
