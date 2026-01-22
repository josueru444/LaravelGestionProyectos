const diasPermitidos = [];
const dia1Select = document.getElementById("dia1-select");
const dia2Select = document.getElementById("dia2-select");
const dia3Select = document.getElementById("dia3-select");
let valores = [];

dia1Select.addEventListener("change", (e) => {
    diasPermitidos[0] = dia1Select.value;
    //console.log(diasPermitidos);
});

dia3Select.addEventListener("change", (e) => {
    diasPermitidos[2] = dia3Select.value;
    //console.log(diasPermitidos);
});

dia2Select.addEventListener("change", (e) => {
    diasPermitidos[1] = dia2Select.value;
    //console.log(diasPermitidos);
});

document.addEventListener("DOMContentLoaded", (e) => {
    diasPermitidos[0] = dia1Select.value;
    diasPermitidos[1] = dia2Select.value;
});

//console.log(diasPermitidos);

const colores = [
    "bg-amber-400",
    "bg-green-400",
    "bg-blue-400",
    "bg-purple-400",
    "bg-lime-400",
    "bg-pink-400",
    "bg-red-400",
    "bg-yellow-400",
    "bg-orange-400",
    "bg-gray-400",
];

let color = "";
let suma = 0;

function dibujarOpciones() {
    const contenedor = document.getElementById("contenedor-opciones");
    contenedor.innerHTML = "";
    let i = 0;
    datos.temario.map(function () {
        const btns = `<button class="${
            colores[i]
        } py-1 px-4 text-center font-bold rounded-md">Unidad ${i + 1}</button>`;
        contenedor.innerHTML += btns;
        i++;
    });
}

// Fechas---------------------------------------------------------------------------------
function sumarSemanas(fecha, semanas) {
    const nuevaFecha = new Date(fecha);
    nuevaFecha.setDate(nuevaFecha.getDate() + semanas * 7);
    return nuevaFecha;
}

function ajustarFecha(fecha, diasPermitidos) {
    const diaSemana = fecha.getDay();

    // Si es un día permitido y no es feriado, retornamos la fecha
    if (diasPermitidos.includes(diaSemana) && !holidays.isHoliday(fecha)) {
        return fecha;
    }

    let fechaAjustada = new Date(fecha);
    let diferenciaMinima = 7; // Valor mayor que cualquier posible diferencia

    diasPermitidos.forEach((dia) => {
        let diferencia = (dia - diaSemana + 7) % 7;
        if (diferencia === 0) {
            diferencia = 7;
        }
        if (diferencia < diferenciaMinima) {
            diferenciaMinima = diferencia;
        }
    });

    fechaAjustada.setDate(fechaAjustada.getDate() + diferenciaMinima);
    return fechaAjustada;
}

function formatearFecha(fecha) {
    return new Intl.DateTimeFormat("es-CL").format(fecha);
}

function dibujasFechas() {
    const inicioCurso = document.getElementById("inicio_curso").value;
    const [year, month, day] = inicioCurso.split("-");
    let fechaBase = new Date(year, month - 1, day);
    let semanasTotales = 0;

    const contendorFechas = document.getElementById("contenedor-fechas");
    contendorFechas.innerHTML = ""; // Limpiar fechas anteriores

    const tr = document.getElementById("tr-TP");
    const tds = tr.querySelectorAll("td");

    const clasesOrdenadas = [
        "bg-amber-400",
        "bg-green-400",
        "bg-blue-400",
        "bg-purple-400",
        "bg-lime-400",
        "bg-pink-400",
        "bg-red-400",
        "bg-yellow-400",
        "bg-orange-400",
        "bg-gray-400",
    ];

    const conteosClases = {};
    clasesOrdenadas.forEach((clase) => (conteosClases[clase] = 0));

    clasesOrdenadas.forEach((clase) => {
        tds.forEach((td) => {
            if (td.classList.contains(clase)) {
                conteosClases[clase]++;
            }
        });
    });

    valores = Object.values(conteosClases);
    //console.log(valores[0]);

    clasesOrdenadas.forEach((clase) => {
        if (conteosClases[clase] > 0) {
            semanasTotales += conteosClases[clase];
            let nuevaFecha = sumarSemanas(fechaBase, semanasTotales);
            nuevaFecha = ajustarFecha(nuevaFecha, diasPermitidos);
            let fechaFormateada = formatearFecha(nuevaFecha);

            const pFecha = document.createElement("p");
            pFecha.textContent = fechaFormateada;
            pFecha.className =
                clase + " px-2 py-1 inline-block mx-1 mb-1 w-fit";

            contendorFechas.appendChild(pFecha);
        }
    });
}

// Eventos------------------------------------------------------------------------------------------------------------------
function btnEventos() {
    const buttons = document.querySelectorAll("button");
    let i = 0;
    buttons.forEach((button) => {
        //console.log(i);
        button.addEventListener("click", (e) => {
            color = e.target.classList[0];

            e.target.disabled = true;

            buttons.forEach((btn) => {
                if (btn !== e.target) {
                    btn.disabled = false;
                }
            });
        });
    });
    var primeraFilaCeldas = document.querySelectorAll(
        "#tbody-calendarizacion tr:first-child td"
    );
    var quintasFilaCeldas = document.querySelectorAll(
        "#tbody-calendarizacion tr:nth-child(5) td"
    );

    primeraFilaCeldas.forEach(function (celda, indice) {
        if (indice != 0 && indice > 0) {
            celda.onclick = function (e) {
                let span = 1;
                let element = e.target;
                element.className = "";
                element.className = "border-2 border-black";
                if (color === "") {
                    alert("Selecciona una unidad para continuar");
                } else {
                    e.target.classList.add(color);

                    var celdaQuintaFila = quintasFilaCeldas[indice];
                    celdaQuintaFila.className = "";
                    celdaQuintaFila.classList.add(color);
                    quintasFilaCeldas.colSpan = span;
                    span++;

                    dibujasFechas();
                }
            };
        }
    });
}

// Inicializar
dibujarOpciones();
btnEventos();

document.addEventListener("submit", (e) => {
    const divfechas = document.getElementById("contenedor-fechas");
    const inputFechas = document.getElementById("inputFechas");
    const inputSemanas = document.getElementById("inputSemanas");

    //console.log(inputFechas);
    const fechas = [];

    let suma = valores.reduce(
        (acumulador, valorActual) => acumulador + valorActual,
        0
    );
    if (suma === 16) {
        divfechas.querySelectorAll("p").forEach((p) => {
            fechas.push(p.textContent);
        });
        inputFechas.value = fechas;
        inputSemanas.value = valores;
    } else {
        e.preventDefault();
        alert("Debe seleccionar las 16 semas de la calendarización");
    }
});
