<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @include('layouts.head')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            important: true,
            theme: {
                extend: {
                    colors: {
                        clifford: "#da373d",
                    },

                },
            },
        }
    </script>
    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body class="font-sans text-gray-900 antialiased">
    @if (Route::has('login'))
    <div>
        <div class="sticky py-4 px-auto flex justify-between bg-white top-0 z-50 w-[95%] mx-auto md:w-[75%] items-center">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 ">Dashboard</a>
            @else
            <a href="/">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
            <div class="" >
                <a href="{{ route('login') }}" class=" text-gray-600 hover:text-gray-100 dark:text-gray-400 hover:no-underline hover:bg-[#00959F] dark:hover:text-white border-2 border-[#00959F] duration-300 font-semibold py-2 rounded-md px-5">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold py-2 rounded-md px-5 hover:text-gray-900 dark:text-gray-400 hover:no-underline dark:hover:text-white bg-[#00959F] text-white border-2 hover:bg-white hover:border-2 border-[#00959F] duration-300">Register</a>
                @endif
            </div>
            @endauth
        </div>
    </div>
    @endif

    <div class="min-h-[94vh] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        {{-- <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div> --}}

        <div
            class="w-full ">
            {{ $slot }}
        </div>
    </div>
    <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
</body>

</html>
