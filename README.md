## Requirements

- php: 8.3
- Node: 20

## Setup on local

- Copy .env file

````
cp .env.example .env
````

- Edit mysql connection in your .env (credential is based on your sql server)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=password
```

- Run ``composer install``
- Run ``npm install``
- Run ``php artisan key:generate``
- Run ``php artisan migrate:refresh``
- Run ``php artisan shield:generate --all``
- Run ``php artisan serve``
- Run ``npm run dev`` (another window)
- Open ``localhost`` on your browser

## Setup on local using sail

- Install Docker https://laravel.com/docs/11.x/installation#docker-installation-using-sail
- Copy .env file

````
cp .env.example .env
````

- Edit mysql connection in your .env (credential is based on your sql server)

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

- Run this command

````
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
````

- Run ``./vendor/bin/sail up -d`` to build and start the container
- Run ``./vendor/bin/sail npm install``
- Run ``./vendor/bin/sail artisan key:generate``
- Run ``./vendor/bin/sail artisan migrate:refresh``
- Run ``./vendor/bin/sail artisan shield:generate --all``
- Run ``./vendor/bin/sail npm run dev``
- Open ``localhost`` on your browser

# How to use

- Always add the `tenant_id` in the newly created migration
- Use the `TenantTrait` in the newly created model
- In the `Tenant` model, add the HasMany relationship of the newly created model
```php
public function posts(): HasMany {
    return $this->hasMany(Post::class);
}
```
- Create an observer class extend it with `BaseObserver`
- Add the newly created `Observer` in the `boot` of `AppServiceProvider`. Check laravel document for more info.
- You can run `shield:generate --all` to generate policies and permissions
