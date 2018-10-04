# A Pipedrive App boilerplate with Laravel
This is a quick-start application that you can re-use to build your own app for [Pipedrive's Marketplace](https://marketplace.pipedrive.com/).

**It already handles the OAuth flow for you.**

Users can login with Pipedrive, using the [Laravel Socialite](https://github.com/SocialiteProviders/Providers) plugin.<br>In all controllers you have access to an instance of this [PHP Client Library](https://github.com/IsraelOrtuno/pipedrive), ready to use.

# How to start
You should already have a Pipedrive Sandbox account and a draft app created. If you don't, please [do that first](https://pipedrive.readme.io/docs/marketplace-creating-a-proper-app).

Clone the repository

```
git clone https://github.com/daniti/pipedrive-laravel.git
```
cd into the folder and run

```
composer install
```
rename .env.example to .env, and generate a key using
```
php artisan key:generate
```
Open .env and add the information about your application, database and the following parameters:
```
PIPEDRIVE_CLIENT_ID=
PIPEDRIVE_CLIENT_SECRET=
PIPEDRIVE_REDIRECT_URI=
```
Create the database tables running:
```
php artisan migrate
```
# You're done!

User authentication is already taken care of, and you can access an instance of the client library in any controller simply using:
```php
$pipedrive = app()->make('\Devio\Pipedrive\Pipedrive');
```
To know how to use the library, read the [official documentation](https://github.com/IsraelOrtuno/pipedrive). Please note that you won't need to handle the instantiation because it's already done for you.

You can read [Laravel's Documentation](https://laravel.com/docs/5.7) for more information.

Build something amazing!
