#!/bin/bash

trap "kill 0" EXIT

php artisan serve --host 0.0.0.0 &
php artisan queue:work &
php artisan schedule:work &

npm run dev -- --host