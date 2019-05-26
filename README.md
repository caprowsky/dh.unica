# Wordpress per dh.unica.it

## Introduzione

Questo progetto è composto da un insieme di immagini docker ottimizate per wordpress. Si ringrazia [wodby](https://wodby.com/) per aver reso disponibili per immagini dal quale questo progetto prende spunto. Per maggiori informazioni si veda [Docker-based WordPress stack (https://wodby.com/docker4wordpress)]

## Stack

Questo stack è costituito dalle seguenti immagini:


| Container       | Versions            | Service name    | Image                              |
| -------------   | ------------------  | ------------    | ---------------------------------- |
| [Nginx]         | 1.15, 1.14          | `nginx`         | [wodby/nginx]                      |
| [PHP]           | 7.3, 7.2, 7.1, 5.6* | `php`           | [wodby/wordpress-php]              |
| [MariaDB]       | 10.3, 10.2, 10.1    | `mariadb`       | [wodby/mariadb]                    |
| [Mailhog]       | latest              | `mailhog`       | [mailhog/mailhog]                  |
| phpMyAdmin      | latest              | `pma`           | [phpmyadmin/phpmyadmin]            |


## Installazione in locale

Esegui il clone del progetto

$ git clone git@github.com:caprowsky/dh.unica.git

Avvia il docker compose

$ docker-compose up -d
