@extends('components.nav')
@section('content')
    <div class="px-5 min-h-screen">
        <h1 class="text-3xl font-bold mb-6 pt-5 text-base-content">Gestión del Grupo</h1>
        <div role="tablist" class="tabs tabs-boxed bg-base-200 p-2">
            
            {{-- Tab 1: Actividades --}}
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Actividades" checked />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6 mt-4">
                
                @for ($unidad = 0; $unidad < $unidades; $unidad++)
                    <div class="collapse collapse-arrow bg-base-200 mb-2">
                        <input type="radio" name="my-accordion-2" />
                        <div class="collapse-title text-xl font-medium">
                            Calificaciones de la unidad {{ $unidad + 1 }}
                        </div>
                        <div class="collapse-content overflow-auto">
                            <div class="overflow-x-auto">
                                <button class="btn btn-primary btn-sm mb-4"
                                    onclick="lista_calificacion.showModal()" id="btRegCal">
                                    Registrar actividades
                                </button>
                                <input type="hidden" id="numero_unidad" value="{{ $unidad + 1 }}">
                                <table class="table table-zebra w-full rounded-md">
                                    <thead class="bg-base-300 text-primary">
                                        <tr>
                                            @php
                                                $firstRow = json_decode($calificaciones[$unidad]['data'], true);
                                                $dynamicKeysOrder = $firstRow ? array_keys($firstRow[0]) : [];
                                            @endphp
                                            @foreach ($dynamicKeysOrder as $key)
                                                <th>{{ $key }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($calificaciones as $row)
                                            @if ($row->unidad == $unidad + 1)
                                                @php
                                                    $rowDataArray = json_decode($row['data'], true);
                                                @endphp
                                                @if (!empty($rowDataArray))
                                                    @foreach ($rowDataArray as $rowData)
                                                        <tr>
                                                            @foreach ($dynamicKeysOrder as $key)
                                                                <td>{{ $rowData[$key] ?? '' }}</td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- Tab 2: Alumnos --}}
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Alumnos" id="tab-alumnos"/>
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6 mt-4">
                <button type="button" onclick="lista_alumnos_modal.showModal()"
                    class="btn btn-info btn-sm mb-4 text-white">
                    Registrar lista de alumnos
                </button>
                <div class="overflow-x-auto" id="alumnos">
                    <form method="POST" id="form-alumno">
                        <table class="table table-zebra w-full">
                            <thead class="bg-base-300 text-info">
                                <tr>
                                    <th>Número de control</th>
                                    <th>Apellido paterno</th>
                                    <th>Apellido materno</th>
                                    <th>Nombre(s)</th>
                                    <th>Acciones</th>
                                </tr>
                                <tr class="bg-base-200">
                                    <td>
                                        <input type="hidden" value="registrar" id="action-input">
                                        <input type="hidden" value="{{ $grupo }}" name="idGrupoAlumno" id="idGrupoAlumno">
                                        <input type="number" required placeholder="Número de control" name="nc" id="nc" class="input input-bordered input-sm w-full">
                                    </td>
                                    <td><input type="text" required placeholder="Apellido Paterno" name="ap" id="AP" class="input input-bordered input-sm w-full"></td>
                                    <td><input type="text" required placeholder="Apellido Materno" name="am" id="AM" class="input input-bordered input-sm w-full"></td>
                                    <td><input type="text" required placeholder="Nombre(s)" name="nombre" id="nombre" class="input input-bordered input-sm w-full"></td>
                                    <td>
                                        <button id="bt-registrar-alumno" type="submit" class="btn btn-success btn-sm text-white">
                                            Registrar
                                        </button>
                                        <button id="btn-mod-alumno" type="submit" class="btn btn-warning btn-sm text-white hidden">
                                            Modificar
                                        </button>
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="tbody-alumnos">
                                @if (isset($alumnos))
                                    @foreach ($alumnos as $alumno)
                                        <tr class="hover">
                                            <td id="td-nc" class="font-bold">{{ $alumno['nc'] }}</td>
                                            <td id="td-ap">{{ $alumno['ap'] }}</td>
                                            <td id="td-am">{{ $alumno['am'] }}</td>
                                            <td id="td-nombres">{{ $alumno['nombres'] }}</td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <div class="tooltip" data-tip="Modificar alumno">
                                                        <button type="button" class="btn btn-ghost btn-xs" onclick="modificarAlumno(this)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" class="fill-warning" viewBox="0 -960 960 960" width="20px">
                                                                <path d="M120-120v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm584-528 56-56-56-56-56 56 56 56Z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="tooltip" data-tip="Eliminar alumno">
                                                        <button id="eliminar-alumno" type="button" class="btn btn-ghost btn-xs" onclick="eliminarAlumno(this)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" class="fill-error" viewBox="0 -960 960 960" width="20px">
                                                                <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm80-160h80v-360h-80v360Zm160 0h80v-360h-80v360Z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>

            {{-- Tab 3: Reportes --}}
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Reportes" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6 mt-4">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full text-center">
                        <thead class="bg-base-300 text-primary">
                            <tr>
                                <th>No.</th>
                                <th>Nombre del reporte</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($reporte = 0; $reporte < 6; $reporte++)
                                <tr>
                                    <td>{{ $reporte + 1 }}</td>
                                    <td>Reporte correspondiente a la Unidad {{ $reporte }}</td>
                                    <td>
                                        <div class="flex justify-center gap-2">
                                            <div class="tooltip" data-tip="Ver reporte">
                                                <button class="btn btn-ghost btn-xs">
                                                    <svg class="fill-success" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px">
                                                        <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="tooltip" data-tip="Modificar">
                                                <button class="btn btn-ghost btn-xs">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" class="fill-warning" viewBox="0 -960 960 960" width="20px">
                                                        <path d="M120-120v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm584-528 56-56-56-56-56 56 56 56Z" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="tooltip" data-tip="Eliminar reporte">
                                                <button class="btn btn-ghost btn-xs">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" class="fill-error" viewBox="0 -960 960 960" width="20px">
                                                        <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm80-160h80v-360h-80v360Zm160 0h80v-360h-80v360Z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    <dialog id="lista_alumnos_modal" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg mb-4">Subir Archivo</h3>
            <p class="mb-4">Seleccione la lista de alumnos</p>
            <form action="/obtener-alumnos" method="POST" class="flex flex-col gap-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $grupo }}" name="id-grupo-alumno-modal">
                <input name="lista_csv" accept=".csv" type="file"
                    class="file-input file-input-bordered file-input-info w-full" />
                <button class="btn btn-success w-full text-white">Subir lista de alumnos</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <dialog id="lista_calificacion" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg mb-4">Subir Calificaciones (CSV)</h3>
            <p class="mb-4">Seleccione la lista de Calificaciones</p>
            <form action="/registrar-calificacion" method="POST" class="flex flex-col gap-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="unidadInputModal" name="unidadInputModal">
                <input type="hidden" value="{{ $grupo }}" name="grupoID">
                <input name="calificaciones_csv" accept=".csv" type="file"
                    class="file-input file-input-bordered file-input-info w-full" />
                <button class="btn btn-success w-full text-white">Registrar Calificaciones</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
        // const Holidays = require('date-holidays');
        // const holidays = new Holidays('MX');
        
        document.addEventListener('DOMContentLoaded', function() {
            var currentUrl = window.location.href;
            var url = new URL(currentUrl);
            var searchParams = new URLSearchParams(url.search);
            var tab = searchParams.get('tab');

            // Select tabs by their aria-labels as there's no unique ID in the new structure for Actividades
            const tabActividades = document.querySelector('input[aria-label="Actividades"]');
            const tabAlumnos = document.querySelector('input[aria-label="Alumnos"]');

            if(tab === '2' && tabAlumnos && tabActividades){
                tabActividades.checked = false;
                tabAlumnos.checked = true;
            }
            console.log('DOM ready');
        });
    </script>
    <script src="{{ asset('js/grupo/registrarAlumno.js') }}"></script>
    <script>
        const btnsRegCalificaciones = document.querySelectorAll('#btRegCal');
        const inputModalCalificacion = document.querySelector('#unidadInputModal');
        btnsRegCalificaciones.forEach(btn => {
            btn.addEventListener('click', e => {
                 // Adjust logic to find #numero_unidad which might be in a different relative position
                const parent = e.target.closest('.overflow-x-auto'); 
                const unidad = parent.querySelector('#numero_unidad')
                inputModalCalificacion.value = unidad.value;
            })
        });
    </script>
    <script>
        function modificarAlumno(params) {
            // Re-grabbing elements as their classes changed
            const btnRegistrar = document.querySelector('#bt-registrar-alumno');
            // Assuming inputAccionAlumno is defined in external JS script or needs to be found
            // If it's global, this is fine. If not, we need to find it by ID if it exists?
            // Actually looking at previous code, inputAccionAlumno wasn't defined in the file, 
            // so it must be in registrarAlumno.js or global. 
            // I'll assume 'action-input' is the id for it based on the form above.
            const inputAccionAlumno = document.querySelector('#action-input');
            
            if(inputAccionAlumno) inputAccionAlumno.value = 'modificar';

            const btnMod = document.querySelector('#btn-mod-alumno');
            const parent = params.closest('tr');
            const tdNC = parent.querySelector('#td-nc');
            const tdAP = parent.querySelector('#td-ap');
            const tdAM = parent.querySelector('#td-am');
            const tdNombres = parent.querySelector('#td-nombres');

            btnRegistrar.classList.add('hidden');
            btnMod.classList.remove('hidden');

            const nc = document.querySelector('#nc');
            const AP = document.querySelector('#AP');
            const AM = document.querySelector('#AM');
            const nombre = document.querySelector('#nombre');

            nc.value = tdNC.textContent;
            nc.disabled = true;

            AP.value = tdAP.textContent;
            AM.value = tdAM.textContent;
            nombre.value = tdNombres.textContent;
        }
    </script>
@endsection
