# Mapu Rayén Backend - Laravel - cómo usar
## Instalación

`$ composer install`     
`$php artisan key:generate`     
`$php artisan migrate`
`$php artisan db:seed --class=ItemsTableSeeder`     
`$php artisan db:seed --class=SalesTableSeeder`     
`$php artisan db:seed --class=ItemSalesTableSeeder`     
    
### Iniciar el server en http://localhost:8000
    
`$php artisan serve`

### Par acceder a la API, ingresar a: http://localhost:8000/api, las respectivas rutas se encuentran en:

                
+ mapu-rayen-backend
    + routes
        + web.php
        
