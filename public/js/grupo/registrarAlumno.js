const nc = document.getElementById("nc");
const AP = document.getElementById("AP");
const AM = document.getElementById("AM");
const nombre = document.getElementById("nombre");
const tbody = document.getElementById("tbody-alumnos");
const inputAccionAlumno = document.getElementById("action-input");
const form = document.getElementById("form-alumno");

form.addEventListener("submit", (e) => {

    e.preventDefault();
    const idGrupoInput = document.getElementById("idGrupoAlumno");

    if (inputAccionAlumno.value === "registrar") {
        fetch("/registrar-alumno-individual", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                idGrupo: idGrupoInput.value,
                nc: nc.value,
                ap: AP.value,
                am: AM.value,
                nombre: nombre.value,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                if (data.status === "ok") {
                    console.log("ok registrar");
                    const tr = `
             <tr class="hover:bg-gray-600 border-b-2 border-b-gray-500">
             <td class="font-bold">${nc.value}</td>
             <td>${AP.value}</td>
             <td>${AM.value}</td>
             <td>${nombre.value}</td>
             <td>
                 <div class="flex justify-center space-x-5">

                     <div class="tooltip" data-tip="Modificar alumno">
                         <button>
                             <svg xmlns="http:www.w3.org/2000/svg" height="30px"
                                 class="fill-orange-400 hover:fill-orange-500"
                                 viewBox="0 -960 960 960" width="30px" fill="#e8eaed">
                                 <path
                                     d="M120-120v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm584-528 56-56-56-56-56 56 56 56Z" />
                             </svg>
                         </button>
                     </div>
                     <div class="tooltip" data-tip="Eliminar alumno">
                         <button h>
                             <svg xmlns="http:www.w3.org/2000/svg" height="30px"
                                 class="fill-red-500 hover:fill-red-600" viewBox="0 -960 960 960"
                                 width="30px" fill="#e8eaed">
                                 <path
                                     d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm80-160h80v-360h-80v360Zm160 0h80v-360h-80v360Z" />
                             </svg>
                         </button>
                     </div>
                 </div>
             </td>
         </tr>
     `;
                    tbody.innerHTML += tr;
                    form.reset();
                }
            })

            .catch((error) => {
                console.log("Error: ", error);
            });
    } else if (inputAccionAlumno.value === "modificar") {
        console.log(nc);

        fetch("/modificar-alumno", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                idGrupo: idGrupoInput.value,
                nc: nc.value,
                ap: AP.value,
                am: AM.value,
                nombre: nombre.value,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "ok") {
                    console.log("ok modificar");
                    const urlActual = window.location.href;
                    const url = new URL(urlActual);
                    url.searchParams.set("tab", "2");
                    window.location.href = url.toString();
                }
            })

            .catch((error) => {
                console.log("Error: ", error);
            });
    }
});

// Eliminar Alumno
function eliminarAlumno(params) {
    const parent=params.closest('tr');
    const idGrupoInput = document.getElementById("idGrupoAlumno");
    const tdNC = (parent.querySelector('#td-nc'));

    if(confirm('¿Desea eliminar este alumno?')){


        fetch("/eliminar-alumno", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                idGrupo: idGrupoInput.value,
                nc: tdNC.textContent,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                 if (data.status==='ok') {
                   parent.remove();
                 }
            })

            .catch((error) => {
                console.log("Error: ", error);
            });

    }else{

    }
}
