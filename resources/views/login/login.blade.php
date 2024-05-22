<!DOCTYPE html>
<html lang="en">
<head>
    <html data-theme="dark"></html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio de sesión</title>
    @vite('resources/css/app.css')
</head>
<body>
    <main class="w-screen h-screen content-center">
        <div class="flex justify-center">
            <form action="" method="POST" class="bg-slate-700 p-6 rounded-xl flex flex-col gap-2">
                @csrf
                <label class="text-2xl ">Iniciar sesión</label>
                <label class="input input-bordered flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" /></svg>
                    <input type="text" class="grow" placeholder="Usuario" name="user"/>
                  </label>
                  <label class="input input-bordered flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path fill-rule="evenodd" d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z" clip-rule="evenodd" /></svg>
                    <input type="password" class="grow" value="" placeholder="Contraseña" name="pass"/>
                  </label>
                  <input type="submit" value="Iniciar sesión" class="cursor-pointer px-3 py-2 bg-blue-500 hover:bg-blue-600 rounded-md text-white">
            </form>
        </div>
    </main>
</body>
</html>