<?php

use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
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
    function responseSuccess($message = null, $data = null, $code = 200)
    {
        $response = [
            'type' => 'success',
            'message' => is_null($message) ? 'Se ha realizado la petición correctamente.' : $message,

        ];
        if (! is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
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
    function responseError($message = null, $data = null, $code = 202)
    {
        $response = [
            'type' => 'error',
            'message' => is_null($message) ? 'Ha ocurrido un error al procesar la petición.' : $message,

        ];
        if (! is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}

if (! function_exists('responseInformation')) {
    /**
     * @param null $message
     * @param null $data
     * @return mixed|string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function responseInformation($message = null, $data = null, $code = 200)
    {
        $response = [
            'type' => 'info',
            'message' => is_null($message) ? 'Mensaje informativo.' : $message,

        ];
        if (! is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}

if (! function_exists('responseWarning')) {
    /**
     * @param null $message
     * @param null $data
     * @return mixed|string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function responseWarning($message = null, $data = null, $code = 200)
    {
        $response = [
            'type' => 'warning',
            'message' => is_null($message) ? 'Mensaje de advertencia.' : $message,

        ];
        if (! is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
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
            throw new \Exception('Error: configurations table not exists. Run [php artisan rarangels:start-config && php artisan migrate] and try again.');
        }
        $configuracion = Configuration::findByKey($key);
        if (is_null($configuracion)) {
            return null;
        }

        return $configuracion->value;
    }
}

//if (! function_exists('isJson')) {
//    /**
//     * @param $key
//     * @return mixed
//     * @throws \Exception
//     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
//     */
//    function isJson($string)
//    {
//        json_decode($string);
//
//        return (json_last_error() == JSON_ERROR_NONE);
//    }
//}

if (! function_exists('messagePrimary')) {
    /**
     * @return mixed
     * @throws \Exception
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function messagePrimary($message)
    {
        Session::flash('primary', $message);
    }
}

if (! function_exists('messageInfo')) {
    /**
     * @return mixed
     * @throws \Exception
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function messageInfo($message)
    {
        Session::flash('info', $message);
    }
}

if (! function_exists('messageWarning')) {
    /**
     * @return mixed
     * @throws \Exception
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function messageWarning($message)
    {
        Session::flash('warning', $message);
    }
}

if (! function_exists('messageDanger')) {
    /**
     * @return mixed
     * @throws \Exception
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function messageDanger($message)
    {
        Session::flash('danger', $message);
    }
}

if (! function_exists('withOldsInput')) {
    /**
     * @param $arrayOrCollection
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    function withOldsInput($arrayOrCollection)
    {
        if ($arrayOrCollection instanceof Collection) {
            $arrayOrCollection = $arrayOrCollection->toArray();
        }

        Session::flash('_old_input', $arrayOrCollection);
    }
}
