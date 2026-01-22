<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Grupos</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-base-300 min-h-screen pb-10">

    <div class="navbar bg-base-100/90 backdrop-blur-md shadow-sm fixed top-0 z-50">
        <div class="container mx-auto">
            <div class="flex-1">
                <a href="{{ route('home') }}" class="btn btn-ghost text-xl gap-2 normal-case">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 md:h-9" alt="Logo">
                    <span class="font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">
                        Gestión Proyectos
                    </span>
                </a>
            </div>
            <div class="flex-none flex items-center gap-3">
                @if (auth()->check())
                    <div class="hidden md:flex items-center gap-2">
                        <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">Inicio</a>
                        <button onclick="input_file_modal.showModal()" class="btn btn-primary btn-sm gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Nuevo Grupo
                        </button>
                    </div>

                    {{-- User Profile Dropdown --}}
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar placeholder border border-base-300">
                            <div class="bg-neutral text-neutral-content rounded-full w-10">
                                <span class="text-xs">{{ substr(auth()->user()->name, 0, 2) }}</span>
                            </div>
                        </div>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-64 border border-base-200">
                            <li class="menu-title px-4 py-2">
                                <span class="text-xs opacity-50 block">Conectado como</span>
                                <span class="font-bold text-base-content block truncate">{{ auth()->user()->name }}</span>
                            </li>
                            <div class="divider my-0"></div>
                            <li class="md:hidden"><a href="{{ route('home') }}">Inicio</a></li>
                            <li class="md:hidden"><button onclick="input_file_modal.showModal()">Nuevo Grupo</button></li>
                            <li>
                                <a href="{{ route('logout') }}" class="text-error hover:bg-error/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Cerrar sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Iniciar Sesión</a>
                @endif
            </div>
        </div>
    </div>

    <main class="pt-20 container mx-auto px-4">
        @yield('content')
    </main>

    {{-- Modal for adding group --}}
    <dialog id="input_file_modal" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg mb-4">Subir Archivo</h3>
            <p class="mb-4">Seleccione el temario de la materia</p>
            <form action="/grupos/" method="POST" class="flex flex-col gap-4" enctype="multipart/form-data">
                @csrf
                <input name="pdf_file" accept=".pdf" type="file"
                    class="file-input file-input-bordered file-input-primary w-full" />
                <button class="btn btn-primary w-full">Subir temario</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

</body>

</html>
