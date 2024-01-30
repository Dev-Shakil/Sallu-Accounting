<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @include('layouts.head')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @layer utilities {
    /* Hide scrollbar for Chrome, Safari and Opera */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
   /* Hide scrollbar for IE, Edge and Firefox */
    .no-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
  }
}
        </style>
    </head>
    {{-- <body class="font-sans">
        <div class="min-h-screen w-full flex">
            <div class="w-1/12 md:block hidden" id="side">
           @include('layouts.sidebar')
            </div>
    
                <!-- Main Content -->
                <main class="md:w-11/12 w-full shadow-lg ">
                    @include('layouts.navigation')
                    <!-- Page Content Goes Here -->
                    {{ $slot }}
                </main>
        </div>
        
    </body> --}}
    <body class="bg-gray-200 antialiased">
        {{-- <nav class="bg-white border-b border-gray-300 sticky top-0">
            <div class="flex justify-between items-center px-9">
                <!-- Aumenté el padding aquí para añadir espacio en los lados -->
                <!-- Ícono de Menú -->
                <button id="menuBtn">
                    <i class="fas fa-bars text-cyan-500 text-lg">dd</i>
                </button>
    
                <!-- Logo -->
                <div class="ml-1">
                    <img src="https://www.emprenderconactitud.com/img/POC%20WCS%20(1).png" alt="logo" class="h-20 w-28">
                </div>
    
                <!-- Ícono de Notificación y Perfil -->
                <div class="space-x-4">
                    <button>
                        <i class="fas fa-bell text-cyan-500 text-lg"></i>
                    </button>
    
                    <!-- Botón de Perfil -->
                    <button>
                        <i class="fas fa-user text-cyan-500 text-lg"></i>
                    </button>
                </div>
            </div>
        </nav> --}}
        @include('layouts.navigation')
    
        <!-- Barra lateral -->
        @include('layouts.sidebar')
    
        <div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-5 mx-2">
    
            {{ $slot }}
        </div>
    
    
        <!-- Script  -->
        <script>
    
            // Agregar lógica para mostrar/ocultar la navegación lateral al hacer clic en el ícono de menú
            const menuBtn = document.getElementById('menuBtn');
            const sideNav = document.getElementById('sideNav');
    
            menuBtn.addEventListener('click', () => {
                sideNav.classList.toggle('hidden');
            });
        </script>
        <script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
    </body>
    
</html>
