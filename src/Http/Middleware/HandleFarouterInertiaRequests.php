<?php

namespace Farouter\Http\Middleware;

use Farouter\Http\Resources\NodeResource;
use Farouter\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        $nodes = Node::root()->with('children')->get();

        return array_merge(parent::share($request), [
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            // Custom shared data, if needed
            'auth' => [
                'user' => $request->user(),
            ],

            'responseId' => Str::uuid(),

            'nodes' => NodeResource::collection($nodes),
        ]);
    }
}
