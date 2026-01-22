<!doctype html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>Inicio de Sesión</title>
</head>

<body class="bg-base-200 min-h-screen flex items-center justify-center">

    <div class="card w-96 bg-base-100 shadow-xl">
        <div class="card-body items-center text-center">
            <h2 class="card-title text-2xl font-bold mb-6">Inicio de Sesión</h2>
            
            <figure class="mb-4">
                 <img class="w-20 h-20" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
            </figure>

            <div class="card-actions w-full">
                <a href="{{ route('microsoft.login') }}" class="btn btn-outline btn-neutral w-full flex items-center gap-2">
                    <img src="https://img.icons8.com/?size=100&id=22989&format=png&color=000000" width="24" alt="Microsoft Logo">
                    <span>Iniciar sesión con cuenta institucional</span>
                </a>
            </div>
        </div>
    </div>

</body>

</html>
