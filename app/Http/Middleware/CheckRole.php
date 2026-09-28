<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     * @param  string[]  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. ഉപയോക്താവ് ലോഗിൻ ചെയ്തിട്ടുണ്ടോ എന്ന് പരിശോധിക്കുന്നു
        $isAuthenticated = auth()->check() || Session::has('authenticated_user') || session()->has('user');

        if (!$isAuthenticated) {
            return redirect()->route('login')->withErrors(['email' => 'ദയവായി ആദ്യം ലോഗിൻ ചെയ്യുക.']);
        }

        $userRole = auth()->check()
            ? (auth()->user()->role ?? 'player')
            : (Session::get('is_admin') === true ? 'admin' : 'player');

        // Normalize roles (e.g. 'player', 'member', 'admin')
        $allowedRoles = array_map('strtolower', $roles);

        if (in_array('player', $allowedRoles) && !in_array('member', $allowedRoles)) {
            $allowedRoles[] = 'member';
        }

        // 2. യൂസറുടെ റോൾ അനുവദനീയമായ റോളുകളുടെ ലിസ്റ്റിൽ ഉണ്ടോ എന്ന് നോക്കുന്നു
        if (in_array(strtolower($userRole), $allowedRoles)) {
            return $next($request);
        }

        // അനുമതിയില്ലെങ്കിൽ 403 Forbidden
        abort(403, 'നിങ്ങൾക്ക് ഈ പേജ് കാണാനുള്ള അനുമതിയില്ല.');
    }
}
