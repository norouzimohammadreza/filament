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
        $setLog = new ActivityLog();
        $setLog->setLog($causer, $url, $queryString, $response->getStatusCode());
        if ($response->getStatusCode() > 400) {
            $setLog->setLog($causer, $url, $queryString, $response->getStatusCode());
        }
        return $response;
    }
}
