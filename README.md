<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img 
            src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" 
            width="400" 
            alt="Laravel Logo" />
    </a>
</p>

<p align="center">
    Tienda "Comercial Anderson" 
</p>

## Levantar el sistema

1. Clonar el repositior
```
git clone 
```
2. Instalar paquetería composer
```
composer install
```
3. Clonar el archivo ```.env.example``` y renombrar a ```.env```
4. Crear y poblar la base de datos
```
php artisan migrate --seed
```
5. Crear y poblar la base de datos una vez ya creada
```
php artisan migrate:fresh --seed
```
6. Levantar el servidor
```
php artisan serve
```
