# frameUP 
---
## Cara Clone
di terminal <br>
``git clone https://github.com/Shochibi/frameUP.git`` <br>
``cd frameUP`` <br>

## Set Up
di terminal <br>
``composer install`` <br>
``npm install`` <br>
``cp .env.example .env`` <br>
``php artisan key:generate`` <br>
``php artisan migrate`` <br>
``php artisan storage:link`` <br>

## Cara nge run (*pake 2 terminal*)
terminal pertama (jangan di close)<br>
``npm run dev`` <br>
terminal kedua (jangan di close)<br>
``php artisan serve`` <br>
lalu buka <br>
``http://127.0.0.1:8000``