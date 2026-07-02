<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureFolderLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $folderLimit = config('docvault.max_dir_count');
        if ($request->user()->folders()->count() <= $folderLimit) {
            Log::info("Limite de pastas nao atingido");
            return $next($request);
        }

        return back()->withErrors(['folder_limit' => 'Você atingiu o limite máximo de pastas permitidas.']);
    }
}
