<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{ Vite::useHotFile('vendor/farouter/farouter.hot')
        ->useBuildDirectory("vendor/farouter")
        ->withEntryPoints(['resources/css/app.css', 'resources/js/app.jsx']) }}
</head>
<body>
    @inertia
</body>
</html>
