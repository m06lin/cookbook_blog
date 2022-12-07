<?php

namespace App\Http\Middleware;

use Closure;
use Psr\Log\LoggerInterface;

class LogWebAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = str_random(6);
        $this->logRequest($request, $id);

        $response = $next($request);

        $this->logResponse($response, $id);

        return $response;
    }

    private function logRequest($request, $id)
    {
        $content = $this->compactText($request->getContent());
        try {
            \Log::info("<$id> Req  ".$request->path().': '.$content, [
                'ip' => $request->ip(),
                // 'header' => $request->header()
            ]);
        } catch (\Exception $e) {
            // ignore log write error
        }
    }

    private function logResponse($response, $id)
    {
        $content = $this->compactText($response->content());
        try {
            \Log::info("<$id> Res ".$this->compactText($content));
        } catch (\Exception $e) {
            // ignore log write error
        }
    }

    private function compactText($text)
    {
        return preg_replace('/\s+/m', '', $text);
    }
}
