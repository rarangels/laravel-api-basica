# api-basica
Api básica: Contiene autenticacion por api_key, roles y permisos para un panel admin 


Opcional: El proveedor de servicios se registrará automáticamente. O puede agregar manualmente el proveedor de servicios en su archivo **config/app.php**:

```
'providers' => [
    Rarangels\ApiBasica\ApiBasicaServiceProvider::class,
];
```


La migración **create_applications_table** y el archivo de configuración **config/api-basica.php** 

Para publicar las migraciones y el archivo de configuracion, debes ejecutar el siguiente comando:

```
php artisan vendor:publish --provider="Rarangels\ApiBasica\ApiBasicaServiceProvider"
```

2020_08_07_205330_create_applications_table.php

php artisan queue:table