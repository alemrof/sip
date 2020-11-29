# Projekt Systemu

## Wstęp

Projekt ma za cel mplementacje internetowego portalu, który dostarczać będzie informacji m. in. o lokalizacji i innych cechach określonego rodzaju obiektów z danego obszaru. Wybranymi przez nas obiektami są składy budowlane. Przykładowe dane opisujące konkretny obiekt to: nazwa punktu, ew. przynależność do sieci tego rodzaju punktów, oferta (kategorie produktów), ceny najbardziej popularnych produktów, lokalizacja geograficzna punktu usługowego. Portal będzie dodatkowo umożliwiał dodatkowe funkcjonalności.


## Aktorzy

- bezpośredni użytkownicy aplikacji,
- administratorzy,
- twórcy oraz osoby zaangażowane w jej utrzymanie.


## Główne funkcje systemu (Sposób ich wywołania i parametry)

- Wyświetlanie mapy
- Znajdowanie trasy
- Wyszukiwanie składu
- Naniesienie na mapę obiektów (składy budowlane)
- Naniesienie na mapę pozycji użytkownika
    - poprzez interfej postawienie markera na mapie.
- Dodawanie i edycja obiektów dla administratora
- Prezentacja informacji o wybranym obiekcie
- Wyliczanie drogi pomiedzy obiektami
- Scalanie markerów przy zmniejszaniu skali
    - Pomniejszenie mapy poprzez interfejs lub scroll myszy
- Znajdowanie składu
- Trasowanie


## Przypadki użycia

[Przypadki użycia - diagram online](https://lucid.app/lucidchart/invitations/accept/5aeeff3c-66a8-4277-9b84-76ac267686b8)
![Przypadki użycia][use-cases] 



## Diagramy sekwencji

[Uwierzytelnianie - diagram online](https://lucid.app/lucidchart/invitations/accept/8f8b7b4d-717c-455a-8884-1de739772dbf)
![uwierzytelnianie][sd-auth]

[Dodawanie składów - diagram online](https://lucid.app/lucidchart/invitations/accept/0ab9f03f-5ef8-4bf6-a1f0-a548879ab0ac)
![dodawanie składów][sd-add-asset]



## Struktury danych i bazy danych

### Bazy danych

<span style="color:red">TODO: ERD: informacja o użytkownika i baza użytkowników (admin, regular user)</span>

[Model ERD](https://lucid.app/lucidchart/invitations/accept/b159eb18-5e39-4430-a0bb-e2351735fe51)

![Database ERD][database-erd]



## Architektura, technologia i narzędzia

### Architektura systemu

Aplikacja zostanie stworzona jako samodzielny system o architekturze *klient - serwer*. Kod będzie zorganizowany według wzorca monolit z podziałem na moduły funkcjonalne, część frontendową i backendową. Frontend odpowiada za interfejs użytkownika, interakcję z sytemem i prezentację danych. Backend odpowiadza za zarządzanie, modyfiakcje, przechowywanie i udostępnianie danych (administracja). Dane z backendu będą udostępnane frontendowi poprzez API.

![Architektura trój warstwowa][triple-layer-arch]


### API

Backend aplikacji udostepnia dane poprzez REST API z danymi w formacie JSON.
API ma dostarczać danych z bazy potrzebnych do wypełnienia interfejsów użytkownika.

Endpointy backend:
- `/sieci-sklepow` - ma zwracać liste wszystkich sieci sklepów 
- `/sklady-budowlane` - ma zwracać listę wszystkich sklepów budowlanych
- `/kategorie-produktów` - ma zwracać listę wszystkich kategorii produktów
- `/produkty` - ma zwracać listę wszystkich produktów


### Środowisko tworzenia aplikacji

- język programowania
    - Frotend (Technologie Web)
        - HTML
        - CSS
        - Javascript
    - Backend
        - PHP
        - SQL (MySql - MariaDB)
- kompilator i środowisko
    - Do edycji kodu źródłowego developer może używać dowolnego edytora, wszystkie potrzebne narzędzia są dostępne z poziomu CLI
    - Aplikacja bedzie serwowana przez Apache HTTP Serwer


## Wykorzystane zasoby

<span style="color:red">TODO: Rozbudować, usunąć pozycje placeholderowe - w kategorie wrzucić wyspecyfikować wykorzystane zasoby, lub usnac kategorie.</span>
<span style="color:red">TODO: frameworki, szablony. uzupełnić migracja bazy, framework symfony / laravel etc.</span>

- biblioteki graficzne
- algorytmy
- klasy, wzorce projektowe, szablony
- dane multimedialne, modele

- Open Layers - komponent mapowy
- Nominati - geokodowanie, zwracanie informacji o punkcie/markerze

## Projekt interfejsu użytkownika

- najważniejsze okna tworzonej aplikacji
- wymagania co do rozmiaru okna
    Interfejs ma być responsywny. Korzystanie z niego ma być możliwe na różnych rozdzielczościach ekranów desktopowych. Wersji na ekrany urządzeń mobilnych w tej wersji nie przewidujemy.





[database-erd]: ./img/database-erd-lucidchart.png
[triple-layer-arch]: ./img/architektura-trojwarstwowa-klient-serwer.jpg
[sd-auth]: ./img/sd-auth.png
[sd-add-asset]: ./img/sd-add-asset.png
[use-cases]: ./img/use-cases.png