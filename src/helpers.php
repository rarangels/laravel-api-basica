<?php

use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Schema;
use Rarangels\ApiBasica\Models\Configuration;

if (! function_exists('response')) {
    /**
     * Return a new response from the application.
     *
     * @param string $content
     * @param int $status
     * @param array $headers
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function response($content = '', $status = 200, array $headers = [])
    {
        $factory = app(ResponseFactory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($content, $status, $headers);
    }
}

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param null $abstract
     * @param array $parameters
     * @return \Illuminate\Container\Container|mixed|object
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($abstract, $parameters);
    }
}

if (! function_exists('responseSuccess')) {
    /**
     * @param null $message
     * @param null $data
     * @return
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function responseSuccess($message = null, $data = null)
    {
        return response()->json([
            'type' => 'success',
            'message' => is_null($message) ? 'Se ha realizado la petición correctamente.' : $message,
            'data' => $data,
        ], 200);
    }
}

if (! function_exists('responseError')) {
    /**
     * @param null $message
     * @param null $data
     * @return
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function responseError($message = null, $data = null)
    {
        return response()->json([
            'type' => 'error',
            'message' => is_null($message) ? 'Ha ocurrido un error al procesar la petición.' : $message,
            'data' => $data,
        ], 202);
    }
}

if (! function_exists('responseInformation')) {
    /**
     * @param null $message
     * @param null $data
     * @return mixed|string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function responseInformation($message = null, $data = null)
    {
        return response()->json([
            'type' => 'info',
            'message' => is_null($message) ? 'Mensaje informativo.' : $message,
            'data' => $data,
        ], 200);
    }
}

if (! function_exists('responseWarning')) {
    /**
     * @param null $message
     * @param null $data
     * @return mixed|string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function responseWarning($message = null, $data = null)
    {
        return response()->json([
            'type' => 'warning',
            'message' => is_null($message) ? 'Mensaje de advertencia.' : $message,
            'data' => $data,
        ], 200);
    }
}

if (! function_exists('api_configuracion')) {
    /**
     * @param $key
     * @return mixed
     * @throws \Exception
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function api_configuracion($key)
    {
        if (! Schema::hasTable('configurations')) {
            throw new \Exception('Error: configurations table not exists. Run [php artisan vendor:publish --provider="Rarangels\ApiBasica\ApiBasicaServiceProvider" && php artisan migrate] and try again.');

        }

        return Configuration::findByKey($key);
    }
}
