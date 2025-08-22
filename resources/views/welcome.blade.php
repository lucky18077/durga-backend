<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @viteReactRefresh
    @vite('resources/js/app.jsx')
</head>

<body>
    <div id="app"></div>
</body>

</html>
