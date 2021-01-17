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
    - Tworzymy bazę danych sip_db, np przy pomocy [phpmyadmin](http://locahost/phpmyadmin)
- Odpalamy konsolę GIT BASH
    - $ git clone [https://github.com/glebocki/sip.git](https://github.com/glebocki/sip.git)
    - Przechodzimy do foldera ./sip/project
    - $ composer install (instalacja zależności PHP)
    - Ze względu na brak pełnej kompatybilności z mariadb należy zmodyfikować nieco bibliotekę grimzy
        - w pliku .\vendor\grimzy\laravel-mysql-spatial\src\Eloquent\.SpatialExpression.php usuwamy 'axis-order=long-lat' z funkcji getValue()
    - $ npm install (instalacja zależności JS)
    - $ php artisan serve (uruchomienie serwera)
- Aplikacja jest dostępna pod adresem http://localhost:8000/
- Wstępne generowanie danych do bazy http://localhost:8000/generatedata