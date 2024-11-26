<?php

namespace App\Http\Middleware;

use App\ActivityLogsFunctions\ActivityLogHelper;
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
        $response = $next($request);

        ActivityLogHelper::logResponse($response);
        if ($response->getStatusCode() > 400) {
            ActivityLogHelper::logErrorResponse($response);
        }

        return $response;
    }
}
