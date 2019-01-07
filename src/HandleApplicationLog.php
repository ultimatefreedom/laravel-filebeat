<?php

namespace Shallowman\Log;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HandleApplicationLog
{
    protected $service;

    public function __construct(LogService $service)
    {
        $this->service = $service;
    }

    public function handle(Request $request, $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response)
    {
        $level = $request->attributes->get('log_level') ?? 'info';
        $context = $request->attributes->get('context');
        $message = $request->attributes->get('message');
        $response = $response->getOriginalContent();
        [$sec, $microSec] = explode('.', LARAVEL_START);
        $microSec = intdiv($microSec, 1000);
        $content = [
            'app' => config('app.name'),
            'uri' => $request->getHost() . $request->getRequestUri(),
            'method' => $request->method(),
            'ip' => $request->getClientIp(),
            'platform' => '',
            'version' => '',
            'os' => '',
            'level' => $level,
            'tag' => '',
            'start' => Carbon::createFromTimestampMs($sec * 1000 + $microSec),
            'end' => Carbon::now()->format('Y-m-d H:i:s.u'),
            'parameters' => $request->all(),
            'details' => [
                'message' => $message,
                'detail' => $context,
            ],
            'response' => [
                'detail' => $response
            ]
        ];

        $this->service->channel('filebeat')->log($level ?? 'info', '', $content);
    }
}