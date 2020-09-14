<?php

namespace Rarangels\ApiBasica\Middleware;

use Closure;
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

            $token = Tokens::findByTokensEnabled($api_token, $key);
            if ($token && $token->application->domain_url != '*' && $request->header('host') != $token->application->domain_url) {
                return responseError('El host no tiene permisos para realizar esta petición.');
                //dd(parse_url($request->header('host')), $request->header('host'), $request->getClientIp(), $request->header('origin'));
            } else {
                return responseError('La api key o el token proporcionado no es permitido.', null, 401);
            }
        } else {
            if (! config('api-basica.general.allow_view_responses_in_browser', false)) {
                return redirect('')->with('error', 'No estas autorizado en realizar esta petición');
            }
        }

        return $next($request);
    }
}
