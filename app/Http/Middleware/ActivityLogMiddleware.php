<?php

namespace App\Http\Middleware;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
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

        ActivityLogHelper::log('HTTP Response')
            ->withProperties([
                'status_code' => $response->getStatusCode(),
            ])
            ->save();
        if ($response->getStatusCode() > 400) {
            ActivityLogHelper::log('HTTP Error Response',LogLevelEnum::High->value)
                ->withProperties([
                    'status_code' => $response->getStatusCode(),
                ])
                ->save();
        }

        return $response;
    }
}
