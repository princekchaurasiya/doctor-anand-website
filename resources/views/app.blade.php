<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="geo.region" content="IN-MH">
    <meta name="geo.placename" content="Mumbai">
    {{-- DEBUG: viteReactRefresh removed; can reconnect HMR when using npm run dev --}}
    @vite(['resources/js/app.tsx', 'resources/css/app.css'])
    @inertiaHead
</head>
<body class="font-sans antialiased">
@inertia
</body>
</html>
