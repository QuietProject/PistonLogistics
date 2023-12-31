const color = "white";

if(document.documentElement.lang === 'es'){
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
            lotes.style.height = document.documentElement.scrollHeight + "px";
            asignarLote.style.display = "";
            all.style.filter = "blur(10px)";
    
            const offset = window.innerHeight / 2;
    
            asignarLote.scrollIntoView({
                behavior: "smooth",
                block: "center",
                inline: "nearest",
            });
    
            const fila = btnAsignar.closest("tr");
            const ID = fila.querySelector('td[data-columna="ID"]').textContent;
            const direccion = fila.querySelector(
                'td[data-columna="direccion"]'
            ).textContent;
            console.log(direccion);
    
            try {
                let miArray = await getStatus();
    
                divArray.innerHTML = `<h1 class="idPaquete">ID de paquete: ${ID}</h1>
        <table id="miTabla">
            <thead>
                <tr>
                    <th class="columnaArray" data-columna="ID_lote">
                        <div>
                            <p>ID Lote</p>
                        </div>
                    </th>
                    <th class="columnaArray" data-columna="codigo">
                        <div>
                            <p>Codigo</p>
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
                        !direccion && array.tipo === 0 ? "none" : "" 
                    }">
                    <td data-columna="ID">${array.ID}</td>
                    <td data-columna="codigo">${array.codigo}</td>
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
    
            btnAsignarDentroDeLote.forEach((btn) => {
                btn.addEventListener("click", (e) => {
                    e.preventDefault();
    
                    Swal.fire({
                        title: "¿Estas seguro?",
                        text: "¿Seguro que quieres asignar este paquete?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Seguro",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // console.log(e.target.getAttribute("href"));
                            window.location.href = e.target.getAttribute("href");
                        }
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
}else{
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
            lotes.style.height = document.documentElement.scrollHeight + "px";
            asignarLote.style.display = "";
            all.style.filter = "blur(10px)";
    
            const offset = window.innerHeight / 2;
    
            asignarLote.scrollIntoView({
                behavior: "smooth",
                block: "center",
                inline: "nearest",
            });
    
            const fila = btnAsignar.closest("tr");
            const ID = fila.querySelector('td[data-columna="ID"]').textContent;
            const direccion = fila.querySelector(
                'td[data-columna="direccion"]'
            ).textContent;
            console.log(direccion);
    
            try {
                let miArray = await getStatus();
    
                divArray.innerHTML = `<h1 class="idPaquete">Package ID: ${ID}</h1>
        <table id="miTabla">
            <thead>
                <tr>
                    <th class="columnaArray" data-columna="ID_lote">
                        <div>
                            <p>Batch ID</p>
                        </div>
                    </th>
                    <th class="columnaArray" data-columna="codigo">
                        <div>
                            <p>Code</p>
                        </div>
                    </th>
                    <th class="columnaArray" data-columna="ID_troncal">
                        <div>
                            <p>Route ID</p>
                        </div>
                    </th>
                    <th class="columnaArray" data-columna="ID_almacen">
                        <div>
                            <p>Warehouse ID</p>
                        </div>
                    </th>
                    <th class="columnaArray" data-columna="fecha_creacion">
                        <div>
                            <p>Creation Date</p>
                        </div>
                    </th>
                    <th class="columnaArray" data-columna="tipo">
                        <div>
                            <p>Type</p>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
            ${miArray
                .map(
                    (array) => `
                    <tr style="display: ${
                        !direccion && array.tipo === 0 ? "none" : "" 
                    }">
                    <td data-columna="ID">${array.ID}</td>
                    <td data-columna="codigo">${array.codigo}</td>
                    <td data-columna="ID_troncal">${array.ID_troncal}</td>
                    <td data-columna="ID_almacen">${array.ID_almacen}</td>
                    <td data-columna="fecha_creacion">${array.fecha_creacion}</td>
                    <td data-columna="tipo">${array.tipo ? "pickup" : "common"}</td>
                    <td class="btnAsignarDentroDeLote"><a href='${getRoute(
                        ID,
                        array.ID
                    )}'>Assign</a></td>
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
    
            btnAsignarDentroDeLote.forEach((btn) => {
                btn.addEventListener("click", (e) => {
                    e.preventDefault();
    
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Surely you want to assign this package?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Confirm",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // console.log(e.target.getAttribute("href"));
                            window.location.href = e.target.getAttribute("href");
                        }
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
}
