#!/bin/bash

trap "kill 0" EXIT

php artisan serve &
php artisan queue:work &
php artisan schedule:work &

npm run dev