<?php

namespace App\Http\Middleware;

use App\ActivityLogsFunctions\ActivityLog;
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
        $queryString = request()->query() ?? null;
        $response = $next($request);
        activity()
            ->causedBy($causer)
            ->event('User activity log')
            ->withProperties([
                'url' => $url,
                'queryString' => $queryString,
                'getStatusCode' => $response->getStatusCode(),
            ])
            ->log('User activity log')
            ->subject($causer);
        if ($response->getStatusCode() > 400) {
            activity()
                ->causedBy($causer)
                ->withProperties([
                    'url' => $url,
                    'queryString' => $queryString,
                    'getStatusCode' => $response->getStatusCode(),
                ])
                ->log('400 Client Error');
        }
        return $response;
    }
}
