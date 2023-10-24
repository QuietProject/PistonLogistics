const color = "black";
const body = document.getElementsByTagName("body");
let i = 0;
let y = 0;

let radios = document.forms["estado"].elements["estado"];
let labels = document.querySelectorAll(".radioBtnEstados label");

for (let i = 0, max = radios.length; i < max; i++) {
    radios[i].addEventListener("change", function () {
        labels.forEach((label, index) => {
            if (radios[index].checked) {
                label.classList.add("checked");
                label.classList.remove("notChecked");
            } else {
                label.classList.remove("checked");
                label.classList.add("notChecked");
            }
        });
        enviarInformacion();
    });
}

function enviarInformacion() {}

const section = document.getElementById("section");
let botonComenzarPrevio = null;
const cantidadRutas = [
    [
        ["Artigas", "7:00 AM", "16:00 PM"],
        ["Salto", "8:30 AM", "17:15 PM"],
    ],
    [
        ["Canelones", "8:30 AM", "15:45 PM"],
        ["Florida", "9:15 AM", "17:30 PM"],
        ["Durazno", "9:00 AM", "16:15 PM"],
    ],
    [
        ["Pedro", "9:30 AM", "17:15 PM"],
        ["Laura", "8:45 AM", "16:30 PM"],
        ["Diego", "10:00 AM", "17:45 PM"],
    ],
    [
        ["Marta", "8:15 AM", "16:30 PM"],
        ["José", "7:45 AM", "16:00 PM"],
        ["Camila", "9:30 AM", "17:45 PM"],
    ],
    [
        ["Paysandú", "7:30 AM", "16:45 PM"],
        ["Rocha", "7:15 AM", "16:30 PM"],
    ],
    [["Andrés", "8:00 AM", "17:15 PM"]],
    [
        ["Carmen", "9:15 AM", "16:30 PM"],
        ["Ramón", "8:30 AM", "17:45 PM"],
    ],
    [
        ["Dolores", "9:45 AM", "17:00 PM"],
        ["Lavalleja", "8:45 AM", "17:00 PM"],
    ],
];

for (let i = 0; i < cantidadRutas.length; i++) {
    const divEnvio = document.createElement("div");
    section.appendChild(divEnvio);
}
const divs = section.querySelectorAll("div");
const disableDivs = document.getElementById("disableDivs");
const envioComenzado = document.getElementById("envioComenzado");
envioComenzado.style.display = "none";
const envioFinalizado = document.getElementById("envioFinalizado");
envioFinalizado.style.display = "none";
let h = 0;

divs.forEach((div, index) => {
    const newDiv = document.createElement("div");
    newDiv.className = `div${index + 1} trabajos`;

    const container = document.createElement("div");

    const rutas = document.createElement("div");

    const btnVerCarga = document.createElement("input");
    btnVerCarga.type = "button";
    btnVerCarga.value = "Ver Carga";

    const btnMapa = document.createElement("input");
    btnMapa.type = "button";
    btnMapa.value = "Mapa";

    const btnComenzar = document.createElement("input");
    btnComenzar.type = "submit";
    btnComenzar.value = "Comenzar";

    btnComenzar.className = "comenzar-btn";

    btnComenzar.addEventListener("click", () => {
        finalizado.disabled = false;

        if (botonComenzarPrevio == null) {
            botonComenzarPrevio = btnComenzar;
            botonComenzarPrevio.classList.remove("comenzar-btn");
            envioComenzado.style.display = "";
            setTimeout(() => {
                envioComenzado.style.opacity = "1";
                setTimeout(() => {
                    envioComenzado.style.opacity = "0";
                    setTimeout(() => {
                        envioComenzado.style.display = "none";
                    }, 1000);
                }, 1000);
            }, 100);
        }

        const botonesComenzar = document.querySelectorAll(".comenzar-btn");
        botonesComenzar.forEach((btn) => {
            if (btn !== btnComenzar) {
                btn.disabled = true;
            }
        });

        finalizado.addEventListener("click", () => {
            if (finalizado.checked) {
                cantidadRutas.splice(h, 1);

                h = 0;
                finalizado.disabled = true;

                volver.style.display = "none";

                envioFinalizado.style.display = "";
                setTimeout(() => {
                    envioFinalizado.style.opacity = "1";
                    setTimeout(() => {
                        envioFinalizado.style.opacity = "0";
                        setTimeout(() => {
                            envioFinalizado.style.display = "none";
                        }, 1000);
                    }, 1000);
                }, 100);

                div.style.display = "none";
                botonComenzarPrevio = null;
                const botonesComenzar = document.querySelectorAll(".comenzar-btn");
                botonesComenzar.forEach((btn) => {
                    btn.disabled = false;
                });
            }
        });
    });

    const divBtns = document.createElement("div");

    const cerrar = document.createElement("i");
    cerrar.className = "bx bx-x-circle";

    document.body.appendChild(newDiv);
    newDiv.appendChild(container);
    newDiv.appendChild(cerrar);
    container.appendChild(rutas);
    container.appendChild(divBtns);
    divBtns.appendChild(btnVerCarga);
    divBtns.appendChild(btnMapa);
    divBtns.appendChild(btnComenzar);

    div.addEventListener("click", () => {
        newDiv.style.zIndex = "2";
        section.style.filter = "blur(10px)";
        disableDivs.style.zIndex = "1";
    });

    cerrar.addEventListener("click", () => {
        newDiv.style.zIndex = "-1";
        section.style.filter = "none";
        disableDivs.style.zIndex = "-1";
    });

    for (let i = 0; i < cantidadRutas[h].length; i++) {
        const ruta = document.createElement("p");
        ruta.textContent = cantidadRutas[h][i][0];
        rutas.appendChild(ruta);
    }

    const newDivMapa = document.createElement("div");
    newDivMapa.className = `${"mapa" + index} mapa`;

    const cerrarMapa = document.createElement("i");
    cerrarMapa.className = "bx bx-x-circle";

    const volver = document.createElement("i");
    volver.className = "bx bx-left-arrow-alt";

    const mapaContainerDiv = document.createElement("div");
    const mapaContainer = document.createElement("div");
    mapaContainer.className = "mapaContainer";

    document.body.appendChild(newDivMapa);
    newDivMapa.appendChild(cerrarMapa);
    newDivMapa.appendChild(volver);
    newDivMapa.appendChild(mapaContainerDiv);

    const horaRetiro = document.createElement("p");
    horaRetiro.textContent = cantidadRutas[h][i][1];

    const horaEntrega = document.createElement("p");
    horaEntrega.textContent = cantidadRutas[h][i][2];

    const finalizado = document.createElement("input");
    finalizado.type = "radio";
    finalizado.disabled = true;

    const infoMapa = document.createElement("div");
    infoMapa.className = "infoMapa";
    mapaContainerDiv.appendChild(mapaContainer);
    const horas = document.createElement("div");
    horas.appendChild(horaRetiro);
    horas.appendChild(horaEntrega);
    infoMapa.appendChild(horas);
    infoMapa.appendChild(finalizado);
    mapaContainerDiv.appendChild(infoMapa);
    mapaContainerDiv.appendChild(infoMapa);

    btnMapa.addEventListener("click", () => {
        newDiv.style.zIndex = "-1";
        newDivMapa.style.zIndex = "3";
        disableDivs.style.zIndex = "1";
    });

    cerrarMapa.addEventListener("click", () => {
        newDivMapa.style.zIndex = "-1";
        disableDivs.style.zIndex = "-1";
        section.style.filter = "none";
    });

    volver.addEventListener("click", () => {
        newDiv.style.zIndex = "2";
        newDivMapa.style.zIndex = "-1";
        disableDivs.style.zIndex = "-1";
    });

    h++;
});
