<?php

namespace Farouter\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleFarouterInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     */
    public function rootView(Request $request): string
    {
        return 'farouter::app'; // Вказуємо ваш кастомний шаблон
    }

    /**
     * Define the props that are shared by default.
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            // Custom shared data, if needed
            'auth' => [
                'user' => $request->user(),
            ],
        ]);
    }
}
