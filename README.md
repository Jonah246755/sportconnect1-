PROJECT DOWNLOADEN

git clone https://github.com/Jonah246755/sportconnect1.git

cd sportconnect1

DEPENDENCIES INSTALLEREN

composer install
npm install

ENVIROMENT OPZETTEN

cp .env.example .env

php artisan key:generate

DATABASE AANMAKEN

php artisan migrate:fresh --seed

FRONTEND BUILDEN

npm run build

SERVER SSTARTEN

php artisan serve

Open browser: http://localhost:8000

9.3 INLOGGEN
Gebruik deze gegevens:

Email: admin@sportconnect.nl

Wachtwoord: password

TESTS DRAAIEN
php artisan test
Verwacht: 59 tests passing
