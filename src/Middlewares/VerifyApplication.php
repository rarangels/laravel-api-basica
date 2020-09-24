<?php

namespace Rarangels\ApiBasica\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Cookie\CookieValuePrefix;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Http\JsonResponse;
use Rarangels\ApiBasica\Models\Tokens;

class VerifyApplication
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The encrypter implementation.
     *
     * @var \Illuminate\Contracts\Encryption\Encrypter
     */
    protected $encrypter;

    public function __construct(Application $app, Encrypter $encrypter)
    {
        $this->app = $app;
        $this->encrypter = $encrypter;
    }

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
            if (! $this->verificarRfTokens($request)) {
                $respuesta_verificarTokens = $this->verificarApiTokens($request);
                if ($respuesta_verificarTokens instanceof JsonResponse) {
                    return $respuesta_verificarTokens;
                }
            }

            if ($request->header('Accept') != 'application/json') {
                return responseError('El tipo de datos no es aceptado.');
            }
            if ($request->header('X-Requested-With') != 'XMLHttpRequest') {
                return responseError('Falta la cabecera X-Requested-With.');
            }
        } else {
            if (! config('api-basica.general.allow_view_responses_in_browser', false)) {
                return redirect('')->with('error', 'No estas autorizado en realizar esta petición');
            }
        }

        return $next($request);
    }

    public static function serialized()
    {
        return EncryptCookies::serialized('XSRF-TOKEN');
    }

    private function verificarRfTokens($request)
    {
        $x_csrf_token = $request->header('X-CSRF-TOKEN');
        $x_xsrf_token = $request->header('X-XSRF-TOKEN');

        if (! $x_csrf_token || ! $x_xsrf_token) {
            return false;
        }

        $x_xsrf_token = CookieValuePrefix::remove($this->encrypter->decrypt($x_xsrf_token, static::serialized()));
        if (! hash_equals($x_xsrf_token, $x_csrf_token)) {
            return false;
        }

        return true;
    }

    private function verificarApiTokens($request)
    {
        $api_token = $request->header('api-token');
        $key = $request->header('api-key');
        if (! $api_token) {
            return responseError('Falta el api-token en la petición.');
        }
        if (! $key && config('api-basica.general.enable_second_factor_auth')) {
            return responseError('Falta la api-key en la petición.');
        }
        $tokens = Tokens::findByTokensEnabled($api_token, $key);
        if ($tokens && $tokens->where('application.domain_url', '*')->count() == 0 && $tokens->where('application.domain_url', $request->header('host'))->count() == 0) {
            return responseError('El host no tiene permisos para realizar esta petición, la api-key y el api-token no son válidos ó el tiempo de validez de la key expiró.', null, 401);
            //dd(parse_url($request->header('host')), $request->header('host'), $request->getClientIp(), $request->header('origin'));
        }
        $request->merge([
            'application' => $tokens->first()->application,
        ]);

        return true;
    }
}
