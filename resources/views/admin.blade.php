<!DOCTYPE html>
<html class="h-full bg-gray-200">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('assets/admin/css/app.css') }}" rel="stylesheet">

    {{-- Inertia --}}
    <script src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign" defer></script>

    {{-- Polyfill --}}
    <script src="https://polyfill.io/v3/polyfill.min.js?features=String.prototype.startsWith" defer></script>

    <script src="{{ mix('assets/admin/js/app.js') }}" defer></script>
    @routes
</head>

<body class="font-sans leading-none text-gray-700 antialiased">
    @inertia
</body>

</html>