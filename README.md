# MY TOY CARS - a simple app for little boys to enjoy their cars

## Set up

1. Clone repo locally
2. cp .env.example to .env
3. Create database in your local mysql
4. run artisan command to create users and cars: 

```bash
php artisan db:wipe && php artisan migrate && php artisan db:seed
```

5. For dev, now run npm watch and artisan serve to serve site
```bash
npm run watch
```
and in another shell
```bash
php artisan serve
```
