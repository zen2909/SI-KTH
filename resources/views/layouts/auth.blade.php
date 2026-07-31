<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login | SI-KTH Sumenep')</title>

    {{-- Tailwind CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center p-4 md:p-10 font-inter antialiased"
    style="background-image: url('{{ asset('images/bg-login.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    @yield('content')
</body>

</html>
