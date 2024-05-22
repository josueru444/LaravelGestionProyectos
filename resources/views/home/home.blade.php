@extends('components.nav')
@section('content')
<div class="m-5 grid xl:grid-cols-4 gap-9 align-middle content-center md:grid-cols-2 sm:grid-cols-1 pt-24">
    @if (session('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        {{ session('message') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        {{ session('error') }}
    </div>
@endif
    @for ($i = 0; $i < 10; $i++)
        <div class="bg-slate-800 hover:bg-slate-600 rounded-md p-5 text-white border-l-8 border-l-blue-500 hover:border-blue-600">
            <p class="font-bold text-xl truncate  ">Grupo Materiadddddddddddddddddddddddddddd</p>
            <p class="my-2">Clave</p>
            <p class="">Créditos: 2-2-4</p>
            <a href="#" class="btn bg-blue-500 hover:bg-blue-600 text-white text-center mt-3 rounded-md  cursor-pointer align-middle w-full hover:underline">Ir al grupo</a>
        </div>
    @endfor

    
</div>
@endsection