<?php

if (! function_exists('responseSuccess')) {
    /**
     * @param null $message
     * @param null $data
     * @return mixed|string
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
     * @return mixed|string
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
