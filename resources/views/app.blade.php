<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }} ">

    {{-- Core stylesheet and JavaScript --}}
    @vite(['resources/js/app.ts','resources/css/app.css'])

    {{-- --}}
    @routes()

    {{-- Core inertia Head --}}
    @inertiaHead

</head>
<body class="font-medium antialiased">

{{-- Core InertiaJS --}}
@inertia

</body>
</html>
