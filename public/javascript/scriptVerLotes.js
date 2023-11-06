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

        if (columnaSeleccionada !== "ID_lote") {
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

const btnsVerPaquetesEnLote = document.querySelectorAll(
    ".btnVerPaquetesEnLote"
);
const paquetes = document.getElementById("paquetes");
const all = document.getElementById("all");

btnsVerPaquetesEnLote.forEach((btnVerPaquetesEnLote, index) => {
    const verPaquete = document.createElement("div");
    verPaquete.classList = `verPaquete${index} verPaquete`;
    verPaquete.style.display = "none";
    paquetes.appendChild(verPaquete);

    const div = document.createElement("div");
    verPaquete.appendChild(div);

    const cerrar = document.createElement("i");
    cerrar.className = "bx bx-x-circle";
    div.appendChild(cerrar);
    const divArray = document.createElement("div");
    div.appendChild(divArray);

    btnVerPaquetesEnLote.addEventListener("click", async () => {
        paquetes.style.zIndex = "1";
        verPaquete.style.display = "";
        all.style.filter = "blur(10px)";

        const fila = btnVerPaquetesEnLote.closest("tr");
        const ID = fila.querySelector('td[data-columna="ID_lote"]').textContent;

        const route = btnVerPaquetesEnLote.getAttribute("data-route");
        const idsLote = btnVerPaquetesEnLote.getAttribute("data-idlote");

        try {
            const response = await fetch(`${route}?idsLote=${idsLote}`);
            if (!response.ok) {
                alert(`Error: ${response.statusText}`);
                return [];
            }
            const data = await response.json();
            const dataArray = Object.values(data); // Convierte las propiedades en un arreglo
            if(dataArray[0] == "Mensaje personalizado para JavaScript"){
                divArray.style.marginTop = "0px"
                divArray.innerHTML =`<h1 class="noPaquetes">No hay paquetes en el Lote con ID: ${ID}</h1>`;
            }else{

            const miArray = dataArray.flatMap((value) => value); // Aplanar el arreglo de objetos
            
            if (Array.isArray(miArray) && miArray.length > 0) {
                divArray.innerHTML = `<h1 class="idLote">ID del lote: ${ID}</h1>
            <table id="miTabla">
                <thead>
                    <tr>
                        <th class="columnaArray" data-columna="ID_paquete">
                            <div>
                                <p>ID Paquete</p>
                            </div>
                        </th>
                        <th class="columnaArray" data-columna="ID_almacen_cliente">
                            <div>
                                <p>ID Almacen Cliente</p>
                            </div>
                        </th>
                        <th class="columnaArray" data-columna="fecha_registrado">
                            <div>
                                <p>Fecha Registrado</p>
                            </div>
                        </th>
                        <th class="columnaArray" data-columna="ID_pickup">
                            <div>
                                <p>ID Pickup</p>
                            </div>
                        </th>
                        <th class="columnaArray" data-columna="direccion">
                            <div>
                                <p>Dirección</p>
                            </div>
                        </th>
                        <th class="columnaArray" data-columna="peso">
                            <div>
                                <p>Peso</p>
                            </div>
                        </th>
                        <th class="columnaArray" data-columna="volumen">
                            <div>
                                <p>Volumen</p>
                            </div>
                        </th>
                        <th class="columnaArray" data-columna="mail">
                            <div>
                                <p>Mail</p>
                            </div>
                        </th>
                        <th class="columnaArray" data-columna="estado">
                            <div>
                                <p>Estado</p>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    ${miArray
                        .map(
                            (array) =>
                                `<tr>
                                <td data-columna="ID">${array.ID}</td>
                                <td data-columna="ID_almacen_cliente">${
                                    array.ID_almacen
                                }</td>
                                <td data-columna="fecha_registrado">${
                                    array.fecha_registrado
                                }</td>
                                <td data-columna="ID_pickup">${
                                    array.ID_pickup
                                }</td>
                                <td data-columna="direccion">${
                                    array.direccion !== null
                                        ? array.direccion
                                        : ""
                                }</td>
                                <td data-columna="peso">${array.peso}</td>
                                <td data-columna="volumen">${array.volumen}</td>
                                <td data-columna="mail">${array.mail}</td>
                                <td data-columna="estado">${array.estado}</td>
                            </tr>`
                        )
                        .join("")}
                        
                </tbody>
            </table>`;
            } else {
                // Maneja el caso en que miArray no es un arreglo
                divArray.innerHTML = "No se encontraron datos";
            }
        }
        } catch (error) {
            console.error("Error al obtener datos:", error);
        }
    });
    cerrar.addEventListener("click", () => {
        paquetes.style.zIndex = "-1";
        verPaquete.style.display = "none";
        all.style.filter = "blur(0px)";
    });
});
