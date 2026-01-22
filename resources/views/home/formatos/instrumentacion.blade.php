@extends('components.nav')
@section('content')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/date-holidays@2.0.0-beta.2/dist/date-holidays.min.js"></script>

<main class="pt-24 mx-24">



    <section class="flex justify-between bg-white px-24 py-8">
        <div>
            <img class="right-0" src="{{ asset('images/logos/SEP_logo.png') }}" alt="sep logo" widp="auto">
        </div>
        <div>
            <img src="{{ asset('images/logos/ITZ_logo.png') }}" alt="ITZ logo" widp="auto">
        </div>
    </section>
    <form action="/descargar-docx" method="POST" class=" text-black bg-white pb-2 px-24 flex flex-col gap-4" id="formulario-instrumentacion">

        {{ csrf_field() }}

        <p class="font-bold text-center">INSTRUMENTACIÓN DIDÁCTICA PARA LA FORMACIÓN Y DESARROLLO DE COMPETENCIAS
            PROFESIONALES</p>
        <p class="font-bold mt-2">1.- Datos de identificación de la materia.</p>
        <div class="mb-8 mt-2">
            <table class="table">
                <tr class="border-2 border-black m-0">
                    <td class="border-2 border-black px-2">Periodo:</td>
                    <td class="border-2 border-black" colspan="7">
                        De
                        <input value="2024-01-30" type="date" required name="inicio_curso" id="inicio_curso"
                            class="text-sm bg-green-200 border-0 text-black px-2 font-semibold ">
                        al
                        <input value="2024-06-01" type="date" required name="fin_curso"
                            class="text-sm bg-green-200 border-0 text-black px-2 font-semibold ">
                        {{-- <input required name="periodo_input" id="periodo_input" type="text" placeholder="ejemplo Enero-Julio /2024" class="truncate w-full text-sm bg-green-200 border-0 text-black px-2 font-semibold"> --}}
                    </td>
                </tr>
                <tr>
                    <td class="border-2 border-black px-2" colspan="2">
                        <p>Nombre de la asignatura:</p>
                    </td>
                    <td class="border-2 border-black" colspan="2">
                        <input required name="asignatura_input" id="asignatura_input" type="text"
                            placeholder="Nombre de la materia"
                            class=" truncate bg-white border-0 text-black px-2 font-semibold w-full">
                    </td>
                    <td class="border-2 border-black px-2" colspan="2">
                        <p>Clave de la asignatura:</p>
                    </td>
                    <td class="border-2 border-black" colspan="2">
                        <input required name="cve_input" id="cve_input" type="text" placeholder="Clave de la materia"
                            class="bg-white border-0 truncate text-black px-2 font-semibold w-full ">
                    </td>
                </tr>
                <tr>
                    <td class="border-2 border-black px-2" colspan="2">
                        <p>Carrera:</p>
                    </td>
                    <td class="border-2 border-black" colspan="2">
                        <input required name="carrera_input" id="carrera_input" type="text" placeholder="Carrera"
                            class="bg-white border-0 text-black px-2 font-semibold w-full">
                    </td>
                    <td class="border-2 border-black px-2" colspan="2">
                        <p>Departamento:</p>
                    </td>
                    <td class="border-2 border-black" colspan="2">
                        <input required name="departamento_input" id="departamento_input" type="text"
                            placeholder="Departamento de la carrera"
                            class="bg-green-200  border-0 text-black px-2 h-10 font-semibold w-full ">
                    </td>
                </tr>
                <tr>
                    <td class="border-2 border-black px-2" colspan="2">
                        <p>Horas teoría-Horas práctica-Créditos:</p>
                    </td>
                    <td class="border-2 border-black" colspan="2">
                        <input required name="creditos_input" id="creditos_input" type="text"
                            placeholder="ejemplo 2-2-4" class="bg-white border-0 text-black px-2 font-semibold  w-full">
                    </td>
                    <td colspan="2" class="px-2 border-2 border-black">
                        <p>Plan de estudios:</p>
                    </td>
                    <td class="border-2 border-black" colspan="2">
                        <input name="planEstudios_input" id="planEstudios_input" type="text"
                            placeholder="Plan de estudios"
                            class="bg-green-200  h-10 text-black px-2 font-semibold w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border-2 border-black px-2">
                        <p>Profesor:</p>
                    </td>
                    <td class="border-2 border-black">
                        <input required name="profesor_input" id="profesor_input" type="text"
                            placeholder="Nombre del profesor" value="{{ auth()->user()->name }}"
                            class="bg-green-200 border-0 h-20 text-black px-2 font-semibold w-full">
                    </td>
                    <td class="border-2 border-black px-2">
                        <p>Grupo:</p>
                    </td>
                    <td class="border-2 border-black">
                        <input required id="grupo_input" name="grupo_input" type="text" placeholder="Grupo"
                            class="bg-green-200 border-0 h-20 text-black px-2 font-semibold  w-full">
                    </td>
                    <td class="border-2 border-black px-2">
                        <p>Aula:</p>
                    </td>
                    <td class="border-2 border-black">
                        <input required name="aula_input" id="aula_input" type="text" placeholder="Aula"
                            class="bg-green-200 border-0 h-20 text-black px-2 font-semibold  w-full">
                    </td>
                    <td class="border-2 border-black px-2">
                        <p>Horario:</p>
                    </td>
                    <td class="border-2 border-black">
                        <div class="flex space-x-3 mb-2">
                            <select name="dia1-horario" id="dia1-select" required
                                class="bg-green-200 my-1  p-1 w-20">
                                <option value="1">Lunes</optiion>
                                <option value="2">Martes</optiion>
                                <option value="3">Miercoles</optiion>
                                <option value="4">Jueves</optiion>
                                <option value="5">Viernes</optiion>
                            </select>
                            <input type="text" placeholder="Ej. 13:00-15:00" required name="hora-input1"
                                id="hora-input1" class="bg-blue-200 font-bold p-1 w-40">
                        </div>
                        <div class="flex space-x-3">
                            <select name="dia2-horario" id="dia2-select" required
                                class="bg-green-200 my-1  p-1 w-20">
                                <option value="1">Lunes</optiion>
                                <option value="2">Martes</optiion>
                                <option value="3" selected>Miercoles</optiion>
                                <option value="4">Jueves</optiion>
                                <option value="5">Viernes</optiion>
                            </select>
                            <input type="text" placeholder="Ej. 13:00-15:00" required name="hora-input2"
                                id="hora-input2" class="bg-blue-200 font-bold p-1 w-40">

                            {{-- Btn mostrar campo --}}
                            <div class="tooltip" data-tip="Agregar dia" id="contenedor-btn-more">
                                <button id="btn-agregar-campoHorario" type="button"
                                    class=" bg-blue-500 rounded-full hover:bg-blue-700">

                                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960"
                                        width="30px" fill="#e8eaed">
                                        <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                                    </svg>
                                </button>
                            </div>

                            {{-- btn ocultar campo --}}

                            <div class="tooltip hidden" data-tip="Quitar dia" id="contenedor-btn-less">
                                <button id="btn-quitar-campoHorario" type="button"
                                    class="bg-green-500 hover:bg-green-700 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960"
                                        width="30px" fill="#e8eaed">
                                        <path d="M200-440v-80h560v80H200Z" />
                                    </svg>

                                </button>
                            </div>


                        </div>

                        <div class=" space-x-3 my-2 hidden" id="contenedor-horario3">

                            <select name="dia3-horario" id="dia3-select" class="bg-green-200 my-1  p-1 w-20">
                                <option value="1" selected>Lunes</optiion>
                                <option value="2">Martes</optiion>
                                <option value="3">Miercoles</optiion>
                                <option value="4">Jueves</optiion>
                                <option value="5" id="option-viernes">Viernes</optiion>
                            </select>
                            <input type="text" placeholder="Ej. 13:00-15:00" name="hora-input3"
                                class=" bg-blue-200 font-bold p-1 w-40">
                        </div>

                        <input value="1" id="horario_input" name="horario_input" type="hidden"
                            placeholder="Horario" class="bg-green-200 border-0 text-black px-2 font-semibold ">
                    </td>
                </tr>
            </table>

        </div>
        <p class="font-bold">2.- Contenido de la materia.</p>

        <div class="py-2 my-5">

            <table class="w-full">
                <tr>
                    <td class="border-2 border-black" colspan="8">

                        <p id="objetivo-p"></p>

                    </td>
                </tr>
                <tr class="font-bold ">
                    <td class="border-2 border-black w-52 ">
                        <p class="text-center">Competencia
                            específica a desarrollar
                            de cada tema</p>
                    </td>
                    <td class="border-2 border-black w-64 ">
                        <p class="text-center">Temas</p>
                    </td>
                    <td class="border-2 border-black w-72">
                        <p class=" text-center">Subtemas</p>
                    </td>
                    <td class="border-2 border-black w-52">
                        <p class="text-center">Práctica</p>
                    </td>
                    <td class="border-2 border-black">
                        <p class="text-center">Hrs. Teórico – Prácticas </p>
                    </td>
                </tr>

                <tbody id="tbody-temario">

                </tbody>

            </table>
        </div>


        <p class="font-bold pt-5 pb-2">3.- Evaluación de la materia (Criterios).</p>

        <table>
            <tr class="bg-gray-300 border-2 border-black">
                <td class="text-center">
                    <p>Indicadores de alcance</p>
                </td>
            </tr>
            <tr>
                <td class="px-8 border-2 border-black py-3" rowspan="1">
                    <ul>
                        <li>
                            a) Se adapta a situaciones y contextos complejos.
                        </li>
                        <li>b) Hace aportaciones a las actividades académicas desarrolladas.</li>
                        <li>c) Propone y/o explica soluciones o procedimientos no vistos en clase (creatividad). </li>
                        <li>d) Introduce recursos y experiencias que promueven un pensamiento crítico; (por ejemplo el
                            uso de las tecnologías de la información estableciendo previamente un criterio). </li>
                        <li>e) Incorpora conocimientos y actividades interdisciplinarias en su aprendizaje. </li>
                        <li>f) Realiza su trabajo de manera autónoma y autorregulada. </li>
                    </ul>
                </td>
            </tr>
        </table>
        <div class="container mx-auto flex flex-col gap-8" id="contenedor-evidencias"></div>
        <div id="contenedor-calendarizacion" class="container mx-auto">
            <p class="font-bold pt-5 pb-2">5. Calendarización de evaluación en semanas.</p>
            <div id="contenedor-opciones" class="m-3 grid grid-cols-6 gap-2 items-center">

            </div>

            <table id="tabla-calendarizacion" class="min-w-full border-collapse border border-gray-400 ">
                <thead>
                    <tr>
                        <th class="border-2 border-black ">Semana</th>
                        <th class="border-2 border-black ">1</th>
                        <th class="border-2 border-black ">2</th>
                        <th class="border-2 border-black ">3</th>
                        <th class="border-2 border-black ">4</th>
                        <th class="border-2 border-black ">5</th>
                        <th class="border-2 border-black ">6</th>
                        <th class="border-2 border-black ">7</th>
                        <th class="border-2 border-black ">8</th>
                        <th class="border-2 border-black ">9</th>
                        <th class="border-2 border-black ">10</th>
                        <th class="border-2 border-black ">11</th>
                        <th class="border-2 border-black ">12</th>
                        <th class="border-2 border-black ">13</th>
                        <th class="border-2 border-black ">14</th>
                        <th class="border-2 border-black ">15</th>
                        <th class="border-2 border-black ">16</th>
                    </tr>
                </thead>
                <tbody id="tbody-calendarizacion">
                    <tr id="tr-TP">
                        <td class="border-2 border-black text-center font-bold">TP</td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                    </tr>
                    <tr class="bg-gray-300">>
                        <td class="border-2 border-black text-center font-bold">TR</td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                    </tr>
                    <tr class="bg-gray-300">
                        <td class="border-2 border-black text-center font-bold">SD</td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                    </tr>
                    <tr>
                        <td class="border-2 border-black text-center font-bold">ED</td>
                        <td class="border-2 border-black text-center" colspan="16" id="examen-diagnostico"></td>

                    </tr>
                    <tr>
                        <td class="border-2 border-black text-center font-bold">EFn</td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                    </tr>
                    <tr class="bg-gray-300">
                        <td class="border-2 border-black text-center font-bold">ES</td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                        <td class="border-2 border-black "></td>
                    </tr>
                    <tr>
                        <td class="border-2 border-black text-center font-bold">Fecha de evaluación formativa
                            <input type="hidden" id="inputFechas" value="" name="inputFechas">
                            <input type="hidden" id="inputSemanas" value="" name="inputSemanas">
                        </td>
                        <td colspan="16" class="border-2 border-black">
                            <div class="my-1" id="contenedor-fechas">

                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="17" class='border-2 border-black'>
                            <strong class="px-2">Observaciones:</strong>

                            <textarea name="observaciones-calendarizacion" id="" cols="30" rows="5"
                                class="w-full bg-green-200 px-2"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="truncate w-36 border-2 border-black h-14">Firma del docente por seguimiento</td>
                        <td colspan="4" class="border-2 border-black"></td>
                        <td colspan="4" class="border-2 border-black"></td>
                        <td colspan="4" class="border-2 border-black"></td>
                        <td colspan="4" class="border-2 border-black"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-5 mb-10">
            <input required type="text" name="jefeAcademico" class="border-b-2 border-black bg-white text-black w-full h-10 text-center">
            <p class="text-center">Nombre del Jefe(a) de Departamento Académico</p>
        </div>

        <input type="submit" class="bg-green-500 hover:bg-green-600 text-white rounded-md py-2 my-5"
            value="Guardar grupo"
            id="btn-enviar">
    </form>

</main>

@if (session('data'))
<script>
    // Asegúrate de escapar correctamente el contenido JSON
    const datos = @json(session('data'));
    console.log(datos);
</script>
@else
<p>No hay datos.</p>
@endif


<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script>
    dayjs().format()
</script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script src="{{ asset('js/home/instrumentacion.js') }}"></script>
<script src="{{ asset('js/home/calendarizacion.js') }}"></script>

{{-- Auto rellenar horario2 y  --}}
<script>
    const inputHora1 = document.getElementById('hora-input1');
    inputHora1.addEventListener('input', e => {
        const inputHora2 = document.getElementById('hora-input2');
        inputHora2.value = e.target.value
    })

    const btnMostrarCampo3Horario = document.getElementById('btn-agregar-campoHorario');
    const btnOcultarCampo3Horario = document.getElementById('contenedor-btn-less');

    btnMostrarCampo3Horario.addEventListener('click', e => {
        const parent = e.target.closest('#contenedor-btn-more');
        parent.classList.add('hidden');
        const contenedorHorario3 = document.getElementById('contenedor-horario3');
        const option = document.getElementById('option-viernes');
        contenedorHorario3.classList.remove('hidden');
        option.selected = true;
        const contenedorLess = document.getElementById('contenedor-btn-less');
        contenedorLess.classList.remove('hidden')
    });

    btnOcultarCampo3Horario.addEventListener('click', e => {
        const parent = e.target.closest('#contenedor-btn-less');
        const contenedorMore = document.getElementById('contenedor-btn-more');
        const contenedorHorario3 = document.getElementById('contenedor-horario3');
        console.log(parent);
        parent.classList.add('hidden');
        contenedorMore.classList.remove('hidden');
        contenedorHorario3.classList.add('hidden');

    })
</script>
<script>
    const trix = document.getElementById(`trix`)

    trix.addEventListener(`input`, e => {
        console.table(`sasa`);

        console.log(e.target.value);

    })

    const inputInicioCurso = document.getElementById('inicio_curso');
    const tdDiagnostico = document.getElementById('examen-diagnostico');
    inputInicioCurso.addEventListener('change', e => {npm
        console.log('aaaa');
        tdDiagnostico.textContent = e.target.value;
    });

    document.addEventListener('DOMContentLoaded', e => {
        tdDiagnostico.textContent = inputInicioCurso.value;
    });
</script>

<script>
    const formulario = document.getElementById('formulario-instrumentacion')
    formulario.addEventListener('submit', e => {
        e.preventDefault();
        const data = new FormData(this);
        console.log(data);


    })
</script>
@endsection