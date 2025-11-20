<?php
namespace NextTecnology\NovaCustomErrors\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class HandleNovaErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->getStatusCode() > 400) {
            $view = 'nova-custom-errors::' . $response->getStatusCode();

            if (view()->exists($view)) {
                return response()->view($view);
            }
        }
        return $response;
    }
}
