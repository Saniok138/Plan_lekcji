Aby uruchomić projekt, upewnij się, że masz zainstalowane:
- Node.js (wersja LTS lub nowsza)
- npm (instalowany razem z Node.js)

1) Sklonowanie repozytorium
git clone <URL_REPOZYTORIUM>
cd <NAZWA_FOLDERU>

2) Instalacja zależności
npm install

3) Konfiguracja środowiska
cp .env.example .env
treśc środka
PORT=3000
DB_HOST=localhost
DB_PORT=5432
DB_USER=admin
DB_PASS=haslo

4) Uruchomienie projektu
npm run dev

5) Dostęp do aplikacji
Po uruchomieniu aplikacji przejdź do http://localhost:3000 (lub innego adresu podanego w pliku .env) w przeglądarce
