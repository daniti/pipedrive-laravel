# A Pipedrive App boilerplate with Laravel

Clone the repository

```
git clone https://github.com/daniti/pipedrive-laravel.git
```
cd into the folder and run

```
composer install
```
rename .env.example to .env, and run
```
php artisan key:generate
```
fill your .env file with the correct value and add the following parameters
```
PIPEDRIVE_CLIENT_ID=
PIPEDRIVE_CLIENT_SECRET=
PIPEDRIVE_REDIRECT_URI=

TOKEN_PASSWORD=
```
Run
```
php artisan migrate
```
# You're done!

Build something amazing!
