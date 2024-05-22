@extends('components.nav')
@section('content')
<main class="pt-24 mx-24">
    <section class="flex justify-between bg-white px-24 py-8">
        <div>
            <img class="right-0" src="{{ asset('images/logos/SEP_logo.png') }}" alt="sep logo" widp="auto">
        </div>
        <div>
            <img src="{{ asset('images/logos/ITZ_logo.png') }}" alt="ITZ logo" widp="auto">
        </div>
    </section>
    <form class="text-black bg-white pb-2 px-24">
        <p class="font-bold text-center">INSTRUMENTACIÓN DIDÁCTICA PARA LA FORMACIÓN Y DESARROLLO DE COMPETENCIAS PROFESIONALES</p>
        <p class="font-bold mt-2">1.- Datos de identificación de la materia.</p>
        <table class="mb-8 mt-2">
            <tr class="border-2 border-black">
                <td  class="border-2 border-black px-2">Periodo:</td>
                <td class="border-2 border-black" colspan="7">
                    <input type="text" placeholder="ejemplo Enero-Julio /2024" class="w-full bg-white border-0 text-black px-2 font-semibold">
                </td>
            </tr>
            <tr>
                <td class="border-2 border-black px-2"  colspan="2">
                    <p>Nombre de la asignatura:</p>
                </td>
                <td class="border-2 border-black" colspan="2">
                    <input type="text" placeholder="Nombre de la materia" class="w-full bg-white border-0 text-black px-2 font-semibold">
                </td>
                <td class="border-2 border-black px-2" colspan="2">
                    <p>Clave de la asignatura:</p>
                </td>
                <td class="border-2 border-black" colspan="2">
                    <input type="text" placeholder="Clave de la materia" class="bg-white border-0 text-black px-2">
                </td>
            </tr>
            <tr>
                <td class="border-2 border-black px-2" colspan="2">
                    <p>Carrera:</p>
                </td>
                <td class="border-2 border-black" colspan="2">
                    <input type="text" placeholder="Carrera" class="bg-white border-0 text-black px-2">
                </td>
                <td class="border-2 border-black px-2" colspan="2">
                    <p>Departamento:</p>
                </td>
                <td class="border-2 border-black" colspan="2">
                    <input type="text" placeholder="Departamento de la carrera" class="bg-white border-0 text-black px-2">
                </td>
            </tr>
            <tr>
                <td class="border-2 border-black px-2" colspan="2">
                    <p>Horas teoría-Horas práctica-Créditos: </p>
                </td>
                <td class="border-2 border-black" colspan="2">
                    <input type="text" placeholder="ejemplo 2-2-4" class="bg-white border-0 text-black px-2">
                </td>
                <td colspan="2" class="px-2">
                    <p>Plan de estudios:</p>
                </td>
                <td class="border-2 border-black" colspan="2">
                    <input type="text" placeholder="Plan de estudios" class="bg-white border-0 text-black px-2">
                </td>
            </tr>
            <tr>
                <td class="border-2 border-black px-2">
                    <p>Profesor:</p>
                </td>
                <td class="border-2 border-black">
                    <input type="text" placeholder="Nomre del profesor" class="bg-white border-0 text-black px-2">
                </td>
                <td class="border-2 border-black px-2">
                    <p>Grupo:</p>
                </td>
                <td class="border-2 border-black w-52"  >
                    <input type="text" placeholder="Grupo" class="bg-white border-0 text-black px-2">
                </td>
                <td class="border-2 border-black px-2">
                    <p>Aula:</p>
                </td>
                <td class="border-2 border-black">
                    <input type="text" placeholder="Aula" class="bg-white border-0 text-black px-2">
                </td>
                <td class="border-2 border-black px-2">
                    <p>Horario:</p>
                </td>
                <td class="border-2 border-black">
                    <input type="text" placeholder="Horario" class="bg-white border-0 text-black px-2">
                </td>
            </tr>
        </table>
        <p class="font-bold">2.- Contenido de la materia.</p>
        <table class="">
            <tr>
                <td class="border-2 border-black" colspan="8">
                    <strong>Objetivo general del curso:</strong>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt saepe id, eum molestias minima esse odit odio, suscipit corrupti asperiores veritatis deserunt, iusto commodi totam perspiciatis. Soluta eos placeat id!</p>
                </td>
            </tr>
            <tr class="font-bold ">
                <td class="border-2 border-black w-52 " >
                    <p class="text-center">Competencia 
                    específica a desarrollar 
                    de cada tema</p>
                </td>
                <td class="border-2 border-black w-64 " >
                    <p class="text-center">Temas</p>
                </td>
                <td class="border-2 border-black w-72">
                    <p class=" text-center">Subtemas</p>
                </td>
                <td class="border-2 border-black w-52" >
                    <p class="text-center">Práctica</p>
                </td>
                <td class="border-2 border-black" >
                    <p class="text-center">Hrs. Teórico – Prácticas </p>
                </td>
            </tr>
            @for ($i = 0; $i < 2; $i++)
            <tr class="text-sm">
                <td class="border-2 border-black px-5">
                    <p>
                    Elabora hojas de cálculo para 
                    la solución de problemas en las 
                    áreas de ingeniería industrial. 
                    </p>
                </td>
                <td class="px-5 border-2 border-black">
                    <p>
                        Introducción a la 
                        computación y hoja 
                        de cálculo  
                    </p>
                </td>
                <td class="px-5 border-2 border-black" >
                    <ul>
                        <li>1.1. Introducción a la computación.</li>
                        <li>1.1. Introducción a la computación.</li>
                        <li>1.1. Introducción a la computación.</li>
                        <li>1.1. Introducción a la computación.</li>
                        <li>1.1. Introducción a la computación.</li>
                        <li>1.1. Introducción a la computación.</li>
                    </ul>
                </td>
                <td class="border-2 border-black">
                    <div class="flex flex-col align-top">
                        <label class="border-b-2 border-b-black">Descripción: <textarea name="" id="" cols="30" rows="2" class="bg-white border-0" ></textarea></label>
                    <label>Resultado <textarea name="" id="" cols="30" rows="2" class="bg-white border-0"></textarea></label>
                    </div>
                </td>
                <td class="border-2 border-black">
                   
                </td>
            </tr>
            @endfor
        </table>
        <p class="font-bold pt-5 pb-2">3.- Evaluación de la materia (Criterios).</p>

        <table>
                <tr class="bg-gray-300 border-2 border-black">
                    <td class="text-center">
                        <p>Indicadores de alcance</p>
                    </td>
                </tr>
                <tr >
                   <td class="px-8 border-2 border-black py-3">
                    <ul>
                        <li>
                            a)  Se adapta a situaciones y contextos complejos.
                        </li>
                        <li>b)	Hace aportaciones a las actividades académicas desarrolladas.</li>
                        <li>c)	Propone y/o explica soluciones o procedimientos no vistos en clase (creatividad). </li>
                        <li>d)	Introduce recursos y experiencias que promueven un pensamiento crítico; (por ejemplo el uso de las tecnologías de la información estableciendo previamente un criterio). </li>
                        <li>e)	Incorpora conocimientos y actividades interdisciplinarias en su aprendizaje. </li>
                        <li>f)	Realiza su trabajo de manera autónoma y autorregulada. </li>
                    </ul>
                   </td>
                </tr>
        </table>

        
    </form>
</main>
@endsection