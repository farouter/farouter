<!DOCTYPE html>
<html class="h-full dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title inertia>Farouter</title>
    @routes
    <script type="module">
        import RefreshRuntime from 'http://localhost:5173/@react-refresh'
        RefreshRuntime.injectIntoGlobalHook(window)
        window.$RefreshReg$ = () => {}
        window.$RefreshSig$ = () => (type) => type
        window.__vite_plugin_react_preamble_installed__ = true
    </script>
    {{ Vite::useHotFile(public_path('vendor/farouter/dist/vite.hot'))->useBuildDirectory('vendor/farouter/dist/build')->withEntryPoints(['resources/js/app.jsx', 'resources/css/app.css']) }}

    @inertiaHead
</head>
<body class="h-full">
    @inertia
</body>
</html>
