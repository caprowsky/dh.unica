***************************************************
*     WPxdamsBridge  v 0.1 beta  info generali    *
***************************************************



nella cartella “admin” sono contenuti tutti i file per la gestione del back end

nella cartella “custom” sono posizionati template e CSS personalizzati

nella cartella “config” il file di configurazione ( vedi di seguito)

nella cartella “templates” le pagine 

per la pubblicazione 

esiste un file archives.json che contiene:
-lista degli archivi
-lista delle tipologie di schede riferite a un padre (tipo di archivio)

identificativo di una scheda = idarchivio@idscheda

nel file deve esistere 
-un'occorrenza per ogni archivio
-un'occorrenza per ogni scheda dove father=id della tipologia archivio

per ogni form di ricerca deve esistere un file idarchivio.json
