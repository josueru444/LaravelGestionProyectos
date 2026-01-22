@extends('components.nav')
@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6 text-base-content">Mis Grupos</h1>
        {{-- Alerts Section --}}
        @if (session('message'))
            <div role="alert" class="alert alert-success mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Grid Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach ($grupos as $grupo)
                <div class="card bg-base-100 shadow-xl border-l-8 border-primary hover:border-l-secondary transition-colors duration-300">
                    <div class="card-body">
                        <h2 class="card-title truncate" title="{{ $grupo->nombre }}">
                            {{ $grupo->nombre }}
                        </h2>
                        <p class="text-sm">Clave: <span class="font-bold border px-1 rounded">{{ $grupo->clave }}</span></p>
                        <p class="text-sm">Créditos: <span class="badge badge-neutral">{{ $grupo->creditos }}</span></p>
                        <div class="card-actions justify-end mt-4">
                            <a href="{{ route('grupo', ['id' =>  $grupo->id_grupo ]) }}" class="btn btn-primary w-full">
                                Ir al grupo
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


