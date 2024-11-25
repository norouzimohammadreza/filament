<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $causer = auth()->user();
        $url = request()->getPathInfo();
        $query = request()->query() ?? 'none';
        $response = $next($request);

//        if ($response->exception !== null)
//            dd($response->getStatusCode(), $response->exception, $response->getContent());
        return $response;
    }
}
