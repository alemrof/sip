# Projekt Systemu

## Architektura systemu

- model oraz struktura na poziomie głównych bloków funkcjonalnych
- diagramy
    - przepływ sterowania
    - danych
    - przypadki użycia klas

Aplikacja zostanie stworzona jako samodzielny system a architekturze *klient - serwer*. Kod będzie zorganizowany według wzorca monolit z podziałem na moduły funkcjonalne i podziałem na część frontendową i backendową. Frontend odpowiada za interfejs użytkowniak, interakcję z sytemem i prezentację danych. Backend odpowiadza za zarządzanie, modyfiakcje, przechowywanie i udostępnianie danych (administracja). Dane z backendu będą udostępnane frontendowi poprzez API.

![Architektura trój warstwowa][triple-layer-arch]

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
- szablon projektu

## Struktury danych

- struktura bazy danych (diagram)

[Model ERD](https://lucid.app/lucidchart/invitations/accept/b159eb18-5e39-4430-a0bb-e2351735fe51)

![Database ERD][database-erd]

## Projekt interfejsu użytkownika

- najważniejsze okna tworzonej aplikacji
- wymagania co do rozmiaru okna
    - dokładne rozmiary podstawowych elementów interfejsu

## Wykorzystane zasoby

- biblioteki graficzne
- algorytmy
- klasy, wzorce projektowe, szablony
- dane multimedialne, modele

## Główne funkcje systemu (Sposób ich wywołania i parametry)


[database-erd]: ./img/database-erd-lucidchart.png
[triple-layer-arch]: ./img/architektura-trojwarstwowa-klient-serwer.jpg
