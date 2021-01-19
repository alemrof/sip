## Instalacja środowiska dla Windows

- [XAMPP](https://www.apachefriends.org/pl/index.html) - apache, php, mysql.
- [GIT](https://git-scm.com/)
- Dowolny edytor kodu, np. [Visual Studio Code](https://code.visualstudio.com/)
- [Composer](https://getcomposer.org/) - dependency manager for PHP
- [nodejs](https://nodejs.org/dist/v14.15.4/node-v14.15.4-x64.msi) - dla npm - dependency manager for JS

## Uruchamianie projektu

- XAMPP Control Panel
    - Start Apache (do podglądu/edycji bazy danych przez phpmyadmin)
    - Start MySQL
    - Tworzymy bazę danych `sip_db`, np przy pomocy [phpmyadmin](http://locahost/phpmyadmin)
- Odpalamy konsolę __GIT BASH__
    - Klonujemy repo
        ```shell
        git clone https://github.com/glebocki/sip.git
        ```
    - Przechodzimy do folderu `cd ./sip/project`
    - `composer install` (instalacja zależności PHP)
    - Ze względu na brak pełnej kompatybilności z mariadb należy zmodyfikować nieco bibliotekę _grimzy_
        - w pliku `.\vendor\grimzy\laravel-mysql-spatial\src\Eloquent\.SpatialExpression.php` usuwamy `'axis-order=long-lat'` z funkcji `getValue()`
    - `npm install` (instalacja zależności JS)
    - `php artisan serve` (uruchomienie serwera)
- Aplikacja jest dostępna pod adresem [localhost:8000](http://localhost:8000/)
- Wstępne generowanie danych do bazy [localhost:8000/generate-data](http://localhost:8000/generate-data)

## Uruchamianie projektu z Sail (docker-compose)

Wymaga: 
- Docker
- docker-compose

Uruchamianie:
1. Zamien w `.env` wartość `DB_HOST` na `DB_HOST=mysql`.
1. W terminalu wprowadz komendy
    ```shell
    sail up -d
    sail artisan migrate:install
    ```
1. Aplikacja jest dostępna pod [localhost](http://localhost)
1. Seeding danych w bazie [localhost/generate-data](http://localhost/generate-data)

Zamykanie:

```shell
sail down       # podobnie jak docker-compose down
sail down -v    # to dodatkowo usuwa volumeny (czyści bazę)
```
