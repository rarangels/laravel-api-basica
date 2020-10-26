<?php

return [
    'models' => [
        'applications' => Rarangels\ApiBasica\Models\Application::class,
    ],

    'table_names' => [
        'applications' => 'applications',
        'applications_tokens' => 'applications_tokens',
    ],


    'general' => [
        /**
         * Se recomienda activar solo en modo desarrollo o para permitir visualizar
         * los datos en el navegador.
         * Para peticiones desde otras aplicaciones se sigue conservando la restricción
         * sin importar el valor que tenga esta variable.
         **/

        'allow_view_responses_in_browser' => false,

        // Habilitar/Deshabilitar el uso de la key adicional. Por defecto solo se usa el API-TOKEN
        'enable_second_factor_auth' => false,

        // Habilitar/Deshabilitar el uso de tiempo límite para los token
        'enable_time_expired' => false,

        // Habilitar/Deshabilitar el uso de notificaciones por correo electrónico
        'send_mail_notification' => false,
    ]
];
