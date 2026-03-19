<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Catat aksi POST/PUT/PATCH/DELETE yang berhasil ke audit_log.
 * Pasang hanya pada route grup yang perlu diaudit.
 */
class LogActivity
{
    /** Route name yang TIDAK perlu dicatat (terlalu noisy) */
    private array $skip = [
        'dashboard',
        'login',
        'logout',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya log mutasi (bukan GET) yang berhasil (2xx / 3xx redirect)
        $isWrite    = in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']);
        $isSuccess  = $response->getStatusCode() < 400;
        $routeName  = $request->route()?->getName() ?? '';
        $shouldSkip = collect($this->skip)->contains(fn($s) => str_contains($routeName, $s));

        if ($isWrite && $isSuccess && ! $shouldSkip && auth()->check()) {
            AuditLog::catat(
                action:      $request->method(),
                description: "Route: {$routeName} | URL: " . $request->fullUrl(),
            );
        }

        return $response;
    }
}
