
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles / Scripts -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
<main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8 dark:bg-gray-900">
    <div class="text-center">
        <p class="text-xl font-semibold text-primary-500 dark:text-primary-600">
            @yield('code')
        </p>
        <h1 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-3xl dark:text-white">
            @yield('title')</h1>
        <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8 dark:text-gray-400">
            @yield('message')</p>
        <div class="mt-10 flex items-center justify-center gap-x-6">

            <a href="{{config('nova.path')}}" class="text-sm font-semibold text-gray-900 dark:text-white">{{__('Go To Main
                Page')}} <span
                    aria-hidden="true">&rarr;</span></a>
        </div>
    </div>
</main>
</body>
</html>
