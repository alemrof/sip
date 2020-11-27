# Projekt Systemu

## Architektura systemu

- model oraz struktura na poziomie głównych bloków funkcjonalnych
- diagramy
    - przepływ sterowania
    - danych
    - przypadki użycia klas

[Przypadki użycia](https://lucid.app/lucidchart/invitations/accept/5aeeff3c-66a8-4277-9b84-76ac267686b8)

 ![Przypadki użycia][use-cases]   

Aplikacja zostanie stworzona jako samodzielny system o architekturze *klient - serwer*. Kod będzie zorganizowany według wzorca monolit z podziałem na moduły funkcjonalne, część frontendową i backendową. Frontend odpowiada za interfejs użytkownika, interakcję z sytemem i prezentację danych. Backend odpowiadza za zarządzanie, modyfiakcje, przechowywanie i udostępnianie danych (administracja). Dane z backendu będą udostępnane frontendowi poprzez API.

![Architektura trój warstwowa][triple-layer-arch]

### API

API udostępniane przez Backend ma dostarczać danych z bazy potrzebnych do wypełnienia interfejsów użytkownika.

Endpointy backend:
- `/sieci-sklepow` - ma zwracać liste wszystkich sieci sklepów 
- `/sklady-budowlane` - ma zwracać listę wszystkich sklepów budowlanych
- `/kategorie-produktów` - ma zwracać listę wszystkich kategorii produktów
- `/produkty` - ma zwracać listę wszystkich produktów

## Środowisko tworzenia aplikacji

- język programowania
    - Frotend (Technologie Web)
        - HTML
        - CSS
        - Javascript
    - Backend
        - PHP
        - SQL
- kompilator i środowisko
    - Do edycji kodu źródłowego developer może używać dowolnego edytora, wszystkie potrzebne narzędzia są dostępne z poziomu CLI
    - Aplikacja bedzie serwowana przez Apache HTTP Serwer
- szablon projektu

## Struktury danych

- struktura bazy danych (diagram)

[Model ERD](https://lucid.app/lucidchart/invitations/accept/b159eb18-5e39-4430-a0bb-e2351735fe51)

![Database ERD][database-erd]

## Projekt interfejsu użytkownika

- najważniejsze okna tworzonej aplikacji
- wymagania co do rozmiaru okna
    Interfejs ma być responsywny. Korzystanie z niego ma być możliwe na różnych rozdzielczościach ekranów desktopowych. Wersji na ekrany urządzeń mobilnych w tej wersji nie przewidujemy.

## Wykorzystane zasoby

- biblioteki graficzne
- algorytmy
- klasy, wzorce projektowe, szablony
- dane multimedialne, modele

- Open Layers - komponent mapowy
- Nominati - geokodowanie, zwracanie informacji o punkcie/markerze

## Główne funkcje systemu (Sposób ich wywołania i parametry)

- Wyświetlanie mapy
- Naniesienie na mapę obiektów (składy budowlane)
- Naniesienie na mapę pozycji użytkownika
    - poprzez interfej postawienie markera na mapie.
- Dodawanie i edycja obiektów dla administratora
- Prezentacja informacji o wybranym obiekcie
- Wyliczanie drogi pomiedzy obiektami
- Scalanie markerów przy zmniejszaniu skali
    - Pomniejszenie mapy poprzez interfejs lub scroll myszy


[database-erd]: ./img/database-erd-lucidchart.png
[triple-layer-arch]: ./img/architektura-trojwarstwowa-klient-serwer.jpg
