# api-basica
Api básica: Contiene autenticacion por api_key, roles y permisos para un panel admin 


Opcional: El proveedor de servicios se registrará automáticamente. O puede agregar manualmente el proveedor de servicios en su archivo **config/app.php**:

```
'providers' => [
    Rarangels\ApiBasica\ApiBasicaServiceProvider::class,
];
```


Para publicar las migraciones y el archivo de configuracion, debes ejecutar el siguiente comando:

```
php artisan rarangels:start-config
```

Para condigurar los filtros y restricciones a las urls

Agregar a **app/Http/Kernel.php** a los $middlewareGroups en la **api** 

```
\Rarangels\ApiBasica\Middleware\VerifyApplication::class,
```

Lo anterior implica que en todas las peticiones deben recibir un **api-token** en los **headers** y solo son aceptadas peticiones de tipo **application/json**.


Para Iniciar el worker de las notificaciones tipo colas

```
php artisan  rarangels:worker-notifications
```

Metas:

- agregar con un comando laravel/permissions con custom a user y log de roles
