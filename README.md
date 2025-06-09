# SystemRoles

A Laravel package to manage user roles.

## Installation

```bash
composer require baberuka/systemroles
```

## Register the Service Provider (if not auto-discovered)
If you're not using Laravel auto-discovery, register the provider manually in config/app.php.
Add the SystemRolesServiceProvider calls to the providers section. 

```
    'providers' => [
        BabeRuka\SystemRoles\SystemRolesServiceProvider::class,
    ],
```
## Publishing

```bash
php artisan vendor:publish --tag=systemroles-config
php artisan vendor:publish --tag=systemroles-views
php artisan vendor:publish --tag=systemroles-assets

```
## Run the Migrations

```bash
php artisan systemroles:migrate
php artisan migrate
php artisan db:seed --class="Database\Seeders\SystemRolesSeeder"

```
## Usage

Visit `/systemroles/admin/roles/index` to check if it's working.

## Documentation

Visit https://www.systemroles.com/ for more detailed documentation. 
