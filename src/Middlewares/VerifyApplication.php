<?php

namespace Rarangels\ApiBasica\Middleware;

use Closure;
use Illuminate\Database\QueryException;
use Rarangels\ApiBasica\Models\Tokens;

class VerifyApplication
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param \Closure $next
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle($request, Closure $next)
    {
        if ($request->ajax()) {
            $api_token = $request->header('api-token');
            $key = $request->header('api-key');
            if (! $api_token) {
                return responseError('Falta el api-token en la petición.');
            }
            if (! $key) {
                return responseError('Falta la Key en la petición.');
            }
            if ($request->header('Accept') != 'application/json') {
                return responseError('El tipo de datos no es aceptado.');
            }
            if ($request->header('X-Requested-With') != 'XMLHttpRequest') {
                return responseError('Falta la cabecera X-Requested-With.');
            }

            try {
                $tokens = Tokens::findByTokensEnabled($api_token, $key);
            } catch (QueryException $exception) {
                return responseError('Existe un error en la base de datos. Por favor intenta mas tarde o contacta al soporte');
            }

            if ($tokens && $tokens->where('application.domain_url', '*')->count() == 0 && $tokens->where('application.domain_url', $request->header('host'))->count() == 0) {
                return responseError('El host no tiene permisos para realizar esta petición ó la key y el token no son válidos.', null, 401);
                //dd(parse_url($request->header('host')), $request->header('host'), $request->getClientIp(), $request->header('origin'));
            }
        } else {
            if (! config('api-basica.general.allow_view_responses_in_browser', false)) {
                return redirect('')->with('error', 'No estas autorizado en realizar esta petición');
            }
        }

        return $next($request);
    }
}
