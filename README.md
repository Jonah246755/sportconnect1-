9.2 Installatie Stappen

Project downloaden

git clone https://github.com/Jonah246755/sportconnect1.git
cd sportconnect1

Dependencies installeren

composer install
npm install

Environment opzetten

cp .env.example .env
php artisan key:generate

Database aanmaken

php artisan migrate:fresh --seed

Frontend builden

npm run build

Server starten

php artisan serve

Open browser: http://localhost:8000

9.3 Inloggen
Gebruik deze gegevens:

Email: admin@sportconnect.nl
Wachtwoord: password

9.4 Tests draaien
php artisan test
Verwacht: 59 tests passing
