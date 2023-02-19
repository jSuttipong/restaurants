# Follow this steps after clone

## 1. 
Install PHP dependencies.
```bash
composer install
```

## 2.
Copy the .env.example file and rename it to .env. Update the APP_KEY value:
```bash
php artisan key:generate
```

## 3.
Create a GOOGLE_MAPS_API_KEY in .env.
```.env
GOOGLE_MAPS_API_KEY=Your key
```

## 4.
Install the npm dependencies.
```bash
npm install
```

# Run project

## 1. 
Start the Laravel development server.

```bash
php artisan serve
```

## 2. 
Compile the front-end.

```bash
npm run dev
```


