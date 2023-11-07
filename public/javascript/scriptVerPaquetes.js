const color = "white";

const columnas = document.querySelectorAll(".columna");

columnas.forEach((columna) => {
    columna.addEventListener("click", () => {
        const columnaSeleccionada = columna.getAttribute("data-columna");
        const titulos = document.querySelectorAll(
            `th[data-columna="${columnaSeleccionada}"]`
        );
        const celdas = document.querySelectorAll(
            `td[data-columna="${columnaSeleccionada}"]`
        );

        if (columnaSeleccionada !== "ID_paquete") {
            // Reemplaza "ID" con la identificación de tu primera columna
            if (titulos.length > 0) {
                if (titulos[0].textContent === "") {
                    titulos.forEach((titulo) => {
                        const contenidoOriginal = titulo.getAttribute(
                            "data-original-content"
                        );
                        titulo.innerHTML = `<div><p>${contenidoOriginal}</p><i class='bx bx-chevron-down'></i></div>`;
                    });
                } else {
                    titulos.forEach((titulo) => {
                        titulo.setAttribute(
                            "data-original-content",
                            titulo.textContent
                        );
                        titulo.innerHTML =
                            "<div><i class='bx bx-chevron-up'></i></div>";
                    });
                }
            }

            celdas.forEach((celda) => {
                if (celda.textContent === "") {
                    const contenidoOriginal = celda.getAttribute(
                        "data-original-content"
                    );
                    celda.textContent = contenidoOriginal;
                } else {
                    celda.setAttribute(
                        "data-original-content",
                        celda.textContent
                    );
                    celda.textContent = "";
                }
            });
        }
    });
});

menu.addEventListener("click", () => {
    const sideMenu = document.getElementById("sideMenu");
    const computedStyles = window.getComputedStyle(sideMenu);
    const rightValue = computedStyles.getPropertyValue("right");

    if (rightValue === "-400px") {
        sideMenu.style.right = "0";
        menu.style.color = "var(--highlight)";
        menu.style.position = "fixed";
    } else {
        sideMenu.style.right = "-400px";
        menu.style.color = `${color}`;
        menu.style.position = "fixed";
    }
});

const btnsAsignar = document.querySelectorAll(".btnAsignar");
const lotes = document.getElementById("lotes");
const all = document.getElementById("all");

btnsAsignar.forEach((btnAsignar, index) => {
    const asignarLote = document.createElement("div");
    asignarLote.classList = `asignarLote${index} asignarLote`;
    asignarLote.style.display = "none";
    lotes.appendChild(asignarLote);

    const div = document.createElement("div");
    asignarLote.appendChild(div);

    const cerrar = document.createElement("i");
    cerrar.className = "bx bx-x-circle";
    div.appendChild(cerrar);

    const divArray = document.createElement("div");
    div.appendChild(divArray);

    btnAsignar.addEventListener("click", async () => {
        lotes.style.zIndex = "1";
        asignarLote.style.display = "";
        all.style.filter = "blur(10px)";

        const fila = btnAsignar.closest("tr");
        const ID = fila.querySelector('td[data-columna="ID"]').textContent;
        const direccion = fila.querySelector(
            'td[data-columna="direccion"]'
        ).textContent;

        try {
            let miArray = await getStatus();
            console.log(miArray);

            divArray.innerHTML = `<h1 class="idPaquete">ID de paquete: ${ID}</h1>
    <table id="miTabla">
        <thead>
            <tr>
                <th class="columnaArray" data-columna="ID_lote">
                    <div>
                        <p>ID Lote</p>
                    </div>
                </th>
                <th class="columnaArray" data-columna="ID_troncal">
                    <div>
                        <p>ID Troncal</p>
                    </div>
                </th>
                <th class="columnaArray" data-columna="ID_almacen">
                    <div>
                        <p>ID Almacen</p>
                    </div>
                </th>
                <th class="columnaArray" data-columna="fecha_creacion">
                    <div>
                        <p>Fecha Creacion</p>
                    </div>
                </th>
                <th class="columnaArray" data-columna="tipo">
                    <div>
                        <p>Tipo</p>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
        ${miArray
            .map(
                (array) => `
                <tr style="display: ${
                    !direccion && array.tipo === false ? "none" : "" 
                }">
                <td data-columna="ID">${array.ID}</td>
                <td data-columna="ID_troncal">${array.ID_troncal}</td>
                <td data-columna="ID_almacen">${array.ID_almacen}</td>
                <td data-columna="fecha_creacion">${array.fecha_creacion}</td>
                <td data-columna="tipo">${array.tipo ? "pickup" : "comun"}</td>
                <td class="btnAsignarDentroDeLote"><a href='${getRoute(
                    ID,
                    array.ID
                )}'>Asignar</a></td>
            </tr>
        `
            )
            .join("")}
        </tbody>
    </table>`;
        } catch (error) {
            console.error("Error al obtener datos:", error);
        }

        const btnAsignarDentroDeLote = divArray.querySelectorAll(
            ".btnAsignarDentroDeLote"
        );

        const confirmacionContainer = document.getElementById("confirmacionContainer");
        const btnConfirmAsignar = document.getElementById("btnConfirmAsignar");
        const btnCancelAsignar = document.getElementById("btnCancelAsignar");

        btnAsignarDentroDeLote.forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();

                // Show the custom modal
                confirmacionContainer.style.display = "block";

                btnConfirmAsignar.addEventListener("click", () => {
                    // Perform the assignment action
                    window.location.href = e.target.getAttribute("href");
                });

                btnCancelAsignar.addEventListener("click", () => {
                    // Close the custom modal
                    confirmacionContainer.style.display = "none";
                });
            });
        });
    });

    cerrar.addEventListener("click", () => {
        lotes.style.zIndex = "-1";
        asignarLote.style.display = "none";
        all.style.filter = "blur(0px)";
    });
});
