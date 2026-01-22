 const datos = {
     nombre: "Algoritmos y Lenguajes de Programaci\u00f3n",
     clave: "INC-1005",
     satca: "2-2-4",
     carrera: "Ingenier\u00eda Industrial",
     competencias: [
         "Resuelve problemas de programaci\u00f3n mediante la aplicaci\u00f3n de herramientas computacionales para el desarrollo de proyectos.",
         "Resuelve problemas de aplicaci\u00f3n e interpreta la soluci\u00f3n utilizando matrices y sistemas de ecuaciones lineales para las diferentes \u00e1reas de la ingenier\u00eda.",
     ],
     temario: [
         {
             tema: "Introducci\u00f3n a la computaci\u00f3n y hoja de c\u00e1lculo",
             subtemas: [
                 "Introducci\u00f3n a la computaci\u00f3n",
                 "Sistemas operativos",
                 "Elementos de Excel",
                 "F\u00f3rmulas y funciones",
                 "Macros",
                 "Aplicaciones",
             ],
         },
         {
             tema: "Desarrollo de l\u00f3gica algor\u00edtmica",
             subtemas: [
                 "Metodolog\u00eda para la soluci\u00f3n de problemas",
                 "Metodolog\u00eda para el dise\u00f1o de software: Top-down, Bottom-up, modular y programaci\u00f3n estructurada",
                 "Elementos y reglas de los lenguajes algor\u00edtmicos",
                 "Implementaci\u00f3n de algoritmos: secuenciales, selectivos, repetitivos",
                 "Pruebas y depuraci\u00f3n",
             ],
         },
         {
             tema: "Introducci\u00f3n a la programaci\u00f3n de un lenguaje estructurado",
             subtemas: [
                 "Introducci\u00f3n y estructura del entorno de un lenguaje de programaci\u00f3n",
                 "Estructura b\u00e1sica de un programa",
                 "Tipos de datos",
                 "Identificadores",
                 "Almacenamiento, direccionamiento y representaci\u00f3n en memoria",
                 "Proposici\u00f3n de asignaci\u00f3n",
                 "Operadores, operandos y expresiones",
                 "Prioridad de operadores, evaluaci\u00f3n de expresiones",
                 "Elaboraci\u00f3n de programas",
                 "Pruebas y depuraci\u00f3n",
             ],
         },
         {
             tema: "Estructuras selectivas y de repetici\u00f3n",
             subtemas: [
                 "Selectiva simple",
                 "Selectiva doble",
                 "Selectiva anidada",
                 "Selectiva m\u00faltiple",
                 "Repetir mientras",
                 "Repetir hasta",
                 "Repetir desde",
                 "Elaboraci\u00f3n de programas",
             ],
         },
         {
             tema: "Arreglos y archivos",
             subtemas: [
                 "Arreglos unidimensionales",
                 "Arreglos bidimensionales y multidimensionales",
                 "Apertura, entrada-salida de datos, y cierre de archivos",
                 "Elaboraci\u00f3n de programas",
             ],
         },
         {
             tema: "Funciones",
             subtemas: [
                 "Introducci\u00f3n",
                 "Funciones est\u00e1ndar",
                 "Entrada y salida de datos",
                 "Funciones definidas por el usuario",
                 "Pase por valor",
                 "Pase por referencia",
                 "Elaboraci\u00f3n de programas",
             ],
         },
     ],
 };

function rellenarInfo(params) {
    const objetivo = document.getElementById("objetivo-p");
    const asignaturaInput = document.getElementById("asignatura_input");
    const claveInput = document.getElementById("cve_input");
    const carreraInput = document.getElementById("carrera_input");
    const depto = document.getElementById("departamento_input");
    const creditosInput = document.getElementById("creditos_input");

    objetivo.innerHTML =
        "<strong>Objetivo general del curso: </strong>" +
        datos.competencias[0] +
        `<input type='hidden' name='objetivo_gral' value='${datos.competencias[0]}' />`;
    asignaturaInput.value = datos.nombre;
    claveInput.value = datos.clave;
    carreraInput.value = datos.carrera;
    depto.value = datos.carrera;
    creditosInput.value = datos.satca;
}

function dibujarTemario(params) {
    const bodyTemario = document.getElementById("tbody-temario");
    let renglon = "";
    let rt = "";
    let uTema = 0;
    datos.temario.map(function (obj) {
        uTema++;
        const subtemaLength = obj.subtemas.length;

        const renglon = `
        <tr class="text-sm">
                <td class="border-2 border-black px-5" rowspan="2">
                    <p id="p-competencia">
                        ${obj.tema}
                    </p>
                    <input type='hidden' name='competencia[]' value='${
                        obj.tema
                    }' />
                </td>
                <td class="px-5 border-2 border-black" rowspan="2">
                    <p id="p-tema">
                        ${obj.tema}
                    </p>
                    <input type='hidden' name='tema[]' value='${obj.tema}' />
                </td>
                <td class="px-5 border-2 border-black" rowspan="2">
                    <ul id="lista-subtema">
                        ${obj.subtemas
                            .map(
                                (subtema, index) =>
                                    `<li>${uTema}.${index + 1} ${subtema}</li>
                                <input type='hidden' name='subtemas[]' value='${uTema}@${subtema}' />`
                            )
                            .join("")}
                    </ul>
                </td>
                <td class="border-2 border-black">
                    <div class="aflex justify-start">
                        <label class="border-b-2 border-b-black">Descripción:
                            <textarea name="descripcion-area[]" cols="30" rows="4" class="textarea textarea-bordered textarea-lg w-full  text-black bg-green-200"></textarea>
                        </label>
                    </div>
                </td>

                <td class="border-2 border-black align-top">
                    <div class="flex flex-col align-top">
                        <p class="border-b-2 border-b-black">P: </p>
                        <textarea name="p-area[]" cols="30" rows="4" class="textarea textarea-bordered textarea-lg w-full  text-black bg-green-200"></textarea>
                    </div>
                </td>
            </tr>
            <tr class="text-sm">
                <td class="border-2 border-black">
                    <div class="flex flex-col align-top">
                        <label>Resultado
                            <textarea name="resultado-area[]" cols="30" rows="4" class="textarea textarea-bordered textarea-lg w-full  text-black bg-green-200"></textarea>
                        </label>
                    </div>
                </td>

                <td class="border-2 border-black">
                    <div class="flex flex-col align-top">
                       <p>R:</p>
                       <textarea name="r-area[]" cols="30" rows="4" class="textarea textarea-bordered textarea-lg w-full  text-black bg-green-200"></textarea>
                    </div>
                </td>
            </tr>`;

        rt += renglon;
    });
    bodyTemario.innerHTML = rt;
}

function dibujarEvidencias(params) {
    const contenedor = document.getElementById("contenedor-evidencias");
    if (!contenedor) {
        console.error("El elemento 'tbody-evidencias' no existe.");
        return;
    }

    let renglon = ``;

    datos.temario.map(function (obj) {
        renglon += `
        <table  class="min-w-full border-collapse border border-gray-400">
        <thead class="bg-gray-300">
            <tr>
                <th rowspan="2" class="border-2 border-black">Evidencia de aprendizaje</th>
                <th rowspan="2" class="border-2 border-black">%</th>
                <th colspan="6" class="border-2 border-black">Indicador de alcance</th>
                <th rowspan="2" class="border-2 border-black">Evaluación formativa de la competencia</th>
            </tr>
            <tr>
                <th class="border-2 w-14 border-black">a)</th>
                <th class="border-2 w-14 border-black">b)</th>
                <th class="border-2 w-14 border-black">c)</th>
                <th class="border-2 w-14 border-black">d)</th>
                <th class="border-2 w-14  border-black">e)</th>
                <th class="border-2 w-14 border-black">f)</th>
            </tr>
        </thead>
        <tbody >
            <tr>
                <td class="border-2 border-black">
                    <input placeholder="Evidencia 1" name="tr1[]" id="evidencia" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-20  text-center">
                    <input placeholder="%" name="tr1[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22   text-center" class="border-2 border-black">
                    <input placeholder="a%" name="tr1[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="b%" name="tr1[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="c%" name="tr1[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="d%" name="tr1[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="e%" name="tr1[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22 text-center">
                    <input placeholder="f%" name="tr1[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black">
                    <input placeholder="Ejemplo: Examen Práctico correspondiente a esta competencia" name="tr1[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
            </tr>


            <tr>
                <td class="border-2 border-black">
                    <input placeholder="Evidencia 2" name="tr2[]" id="evidencia" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-20  text-center">
                    <input placeholder="%" name="tr2[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22   text-center" class="border-2 border-black">
                    <input placeholder="a%" name="tr2[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="b%" name="tr2[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="c%" name="tr2[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="d%" name="tr2[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="e%" name="tr2[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22 text-center">
                    <input placeholder="f%" name="tr2[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black">
                    <input placeholder="Ejemplo: Examen Práctico correspondiente a esta competencia" name="tr2[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
            </tr>


            <tr>
                <td class="border-2 border-black">
                    <input placeholder="Evidencia 3" name="tr3[]" id="evidencia" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-20  text-center">
                    <input placeholder="%" name="tr3[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22   text-center" class="border-2 border-black">
                    <input placeholder="a%" name="tr3[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="b%" name="tr3[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="c%" name="tr3[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="d%" name="tr3[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="e%" name="tr3[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22 text-center">
                    <input placeholder="f%" name="tr3[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black">
                    <input placeholder="Ejemplo: Examen Práctico correspondiente a esta competencia" name="tr3[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
            </tr>

            <tr class='hidden' id='tr-4'>
                <td class="border-2 border-black">
                    <input placeholder="Evidencia 4" name="tr4[]" id="evidencia" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-20  text-center">
                    <input placeholder="%" name="tr4[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22   text-center" class="border-2 border-black">
                    <input placeholder="a%" name="tr4[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="b%" name="tr4[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="c%" name="tr4[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="d%" name="tr4[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="e%" name="tr4[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22 text-center">
                    <input placeholder="f%" name="tr4[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black">
                    <input placeholder="Ejemplo: Examen Práctico correspondiente a esta competencia" name="tr4[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
            </tr>

            <tr class='hidden' id='tr-5'>
                <td class="border-2 border-black">
                    <input placeholder="Evidencia 5" name="tr5[]" id="evidencia" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-20  text-center">
                    <input placeholder="%" name="tr5[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22   text-center" class="border-2 border-black">
                    <input placeholder="a%" name="tr5[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="b%" name="tr5[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="c%" name="tr5[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="d%" name="tr5[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22  text-center">
                    <input placeholder="e%" name="tr5[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black w-22 text-center">
                    <input placeholder="f%" name="tr5[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
                <td class="border-2 border-black">
                    <input placeholder="Ejemplo: Examen Práctico correspondiente a esta competencia" name="tr5[]" type="text" class="bg-green-200 w-full border-0 text-sm">
                </td>
            </tr>
            <tr>
            <td class="border-2 border-black">Total
                <input type='hidden' value='Total' name="tr6[]">
            </td>
            <td class="border-2 border-black w-20 text-center">
                <input placeholder="100%" name="tr6[]" value='100%' type="text" class="bg-green-200 h-10 w-full border-0 text-sm">
            </td>
            <td class="border-2 border-black w-22 text-center">
                <input placeholder="total %" name="tr6[]" type="text" class="bg-green-200 h-10 w-full border-0 text-sm">
            </td>
            <td class="border-2 border-black w-22 text-center">
                <input placeholder="total %" name="tr6[]" type="text" class="bg-green-200 h-10 w-full border-0 text-sm">
            </td>
            <td class="border-2 border-black w-22 text-center">
                <input placeholder="total %" name="tr6[]" type="text" class="bg-green-200 h-10 w-full border-0 text-sm">
            </td>
            <td class="border-2 border-black w-22 text-center">
                <input placeholder="total %" name="tr6[]" type="text" class="bg-green-200 h-10 w-full border-0 text-sm">
            </td>
            <td class="border-2 border-black w-22 text-center">
                <input placeholder="total %" name="tr6[]" type="text" class="bg-green-200 h-10 w-full border-0 text-sm">
            </td>
            <td class="border-2 border-black w-22 text-center">
                <input placeholder="total %" name="tr6[]" type="text" class="bg-green-200 h-10 w-full border-0 text-sm">
            </td>
            <td class="border-2 border-black">
                <input name="tr6[]" type="hidden" class='bg-white text-black'>
                <div class='flex justify-center'>
                    <button type='button' id='btn-add-row' class='cursor-pointer bg-lime-500 m-1 text-white hover:bg-lime-600 py-1 px-3 rounded-md'>
                        Agregar actividad
                        <svg xmlns="http://www.w3.org/200white0/svg" class='fill-current inline-block' height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                            <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                        </svg>
                    </button>
                    <button type='button' id='btn-add-row2' class='hidden cursor-pointer bg-lime-500 m-1 text-white hover:bg-lime-600 py-1 px-3 rounded-md'>
                        Agregar actividad
                        <svg xmlns="http://www.w3.org/200white0/svg" class='fill-current inline-block' height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                            <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                        </svg>
                    </button>
                </div>
            </td>
        </tr>

        </tbody>
    </table>`;
    });

    contenedor.innerHTML =
        '<p class="font-bold pt-5 pb-2">4.-Evidencias de aprendizaje. (Mínimo 3 dependiendo el tema y competencia específica).</p>' +
        renglon;
}

function eventosBtn1() {
    const btns = document.querySelectorAll("#btn-add-row");

    btns.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const tbody = btn.parentNode.parentNode.parentNode.parentNode;
            const btn5 = tbody.querySelector("#btn-add-row2");
            const row4 = tbody.querySelector("#tr-4");
            row4.className = "";
            btn.className = "hidden";
            btn5.classList.remove("hidden");
        });
    });
}
function eventosBtn2() {
    const btns = document.querySelectorAll("#btn-add-row2");

    btns.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const tbody = btn.parentNode.parentNode.parentNode.parentNode;
            const row5 = tbody.querySelector("#tr-5");
            row5.className = "";
            btn.className = "hidden";
        });
    });
}

rellenarInfo();
dibujarTemario();
dibujarEvidencias();
eventosBtn1();
eventosBtn2();
