<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se o usuário não estiver autenticado, redireciona pro login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user(); // Pega os dados do user

        // Verifica se o usuário é vendedor
        if (!$user->seller) {
            // Se não tiver relação de vendedor, redireciona pro formulário de cadastro de vendedor
            return redirect()->route('seller.create')
                ->with('message', 'Você precisa se cadastrar como vendedor antes de anunciar ingressos.');
        }

        return $next($request);
    }
}
