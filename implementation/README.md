Rychlé spuštění celé aplikace (s daty na testování):
====================================================

1)  nastavení jména serveru

    jménu "iothome.cz" je třeba přiřadit skutečná IP adresa počítače;
    adresu vložte do souboru `/etc/hosts` 

2)  spuštění serverové části

        cd webserver
        docker-compose up -d
        cd ..

3)  inicializace databáze

        docker exec -ti webserver_db_1 mysql < webserver/db-example.sql

4)  spuštění brány

        cd gateway
        ./example.sh

5) otevřít prohlížeč na http://iothome.cz




Spuštění celé aplikace (s minimálními počátečními daty):
==================================


1)  nastavení jména serveru

    jménu "iothome.cz" je třeba přiřadit skutečná IP adresa počítače;
    adresu vložte do souboru `/etc/hosts`

2)  spuštění serverové části

        cd webserver
        docker-compose up -d
        cd ..

3)  inicializace databáze

        docker exec -ti webserver_db_1 mysql < webserver/db-schema.sql
        docker exec -ti webserver_db_1 mysql < webserver/db-init-data.sql

4)  spuštění brány

        cd gateway
        cp gateway_default_config.json config.json
        edit config.json	# upravit podle potřeby
        sed -i 's/gateway_example//' docker-compose.yml # upravit skutečné jméno konfig. souboru
        docker-compose up -d
        cd ..

5) otevřít prohlížeč na http://iothome.cz

