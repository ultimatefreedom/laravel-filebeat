<?php

namespace Shallowman\Log;

use Illuminate\Http\Request;
use Carbon\Carbon;
use stdClass;

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

    /**
     * standardize response content data structure
     * @param $response string response content
     * @return mixed|stdClass
     */
    protected function standardResponse($response)
    {
        if (!$response) {
            return new stdClass();
        }

        $response = @json_decode($response, true);

        if (is_array($response) && array_key_exists('data', $response)) {
            $response['data'] = json_encode($response['data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param $response
     * write application log when response to the request client
     */
    public function terminate($request, $response)
    {
        $level = $request->attributes->get('log_level') ?: 'info';
        $context = $request->attributes->get('context');
        $message = $request->attributes->get('message');
        $response = $this->standardResponse($response->getContent());
        $now = Carbon::now();

        $content = [
            'app' => config('app.name'),
            'uri' => $request->getHost() . $request->getRequestUri(),
            'method' => $request->method(),
            'ip' => implode('|', $request->getClientIps()),
            'platform' => '',
            'version' => '',
            'os' => '',
            'level' => $level,
            'tag' => '',
            'start' => Carbon::createFromTimestampMs(round(LARAVEL_START, 3))->format('Y-m-d H:i:s.u'),
            'end' => $now->format('Y-m-d H:i:s.u'),
            'parameters' => json_encode($request->all(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'performance' => round(microtime(true) - LARAVEL_START, 3),
            'details' => [
                'message' => $message,
                'detail' => $context,
            ],
            'response' => $response,
        ];

        $timestamp = substr($now->setTimezone('UTC')->format('Y-m-d\TH:i:s.u'), 0, -3) . 'Z';
        $this->service->channel('filebeat')->log($level, '', ['api' => $content, '@timestamp' => $timestamp]);
    }
}