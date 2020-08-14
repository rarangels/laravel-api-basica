<?php

namespace Rarangels\ApiBasica\Middleware;

use Rarangels\ApiBasica\Models\Application;
use Closure;

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
            $token = $request->header('api-token');
            if (! $token) {
                return response()->json(['message' => 'Falta el api-token en la petición.'], 400);
            }
            if ($request->header('Accept') != 'application/json') {
                return response()->json(['message' => 'El tipo de datos no es aceptado.'], 400);
            }
            if ($request->header('X-Requested-With') != 'XMLHttpRequest') {
                return response()->json(['message' => 'Falta la cabecera X-Requested-With.'], 400);
            }
            if (! Application::findByToken($token)) {
                return response()->json(['message' => 'La api key proporcionada no es permitida, por favor contactar a '.env('MAIL_CONTACT').' o verifique que la api key esté correcta.'], 401);
            }
        } else {
            if (! config('api-basica.general.allow_view_responses_in_browser', false)) {
                return redirect('')->with('error', 'No estas autorizado en realizar esta petición');
            }
        }

        return $next($request);
    }
}
