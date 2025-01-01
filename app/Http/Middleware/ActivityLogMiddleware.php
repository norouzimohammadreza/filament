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
        $models = config('farda_activity_log.models');
        \App\Models\ModelLogSetting::firstOrCreate([
            'model_type' => 'App'
        ]);
        for($i=0;$i<sizeof($models);$i++){
            \App\Models\ModelLogSetting::firstOrCreate([
                'model_type' => ($models[$i])
            ]);
        }

        $response = $next($request);

        ActivityLogHelper::getInstance()->log('HTTP Response')
            ->withProperties([
                'status_code' => $response->getStatusCode(),
            ])
            ->save();
        if ($response->getStatusCode() > 400) {
            ActivityLogHelper::getInstance()->log('HTTP Error Response')
                ->withProperties([
                    'status_code' => $response->getStatusCode(),
                ])
                ->save();
        }

        return $response;
    }
}
