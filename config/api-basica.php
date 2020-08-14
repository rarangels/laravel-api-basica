<?php

return [
    'models' => [
        'applications' => Rarangels\ApiBasica\Models\Application::class,
    ],

    'table_names' => [
        'applications' => 'applications',
    ],


    'general' => [
        /**
         * Se recomienda activar solo en modo desarrollo o para permitir visualizar
         * los datos en el navegador.
         * Para peticiones desde otras aplicaciones se sigue conservando la restricción
         * sin importar el valor que tenga esta variable.
        **/

        'allow_view_responses_in_browser' => false
    ]
];
