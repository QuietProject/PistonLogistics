if (document.documentElement.lang === "es") {
    const color = "black";
    let abierto = null;
    const section = document.getElementById("section");

    const envio = document.createElement("div");
    envio.className = "envio";
    const carga = document.createElement("div");
    carga.style.display = "none";
    carga.className = "carga";
    const mapa = document.createElement("div");
    mapa.style.display = "none";
    mapa.className = "mapa";

    carga.innerHTML += `<div id='btnVolverCarga'><i class='bx bx-left-arrow-alt'></i></div><h1>Carga</h1><table id="miTabla">
                <thead>
                    <tr>
                        <th class="columna" data-columna="codigo">
                            <div>
                                <p>Codigo</p>
                            </div>
                        </th>
                        <th class="columna" data-columna="peso">
                            <div>
                                <p>Peso</p>
                            </div>
                        </th>
                    </tr> 
                </thead>
                <tbody>
                ${lotes
                    .map(
                        (lote) =>
                            `<tr class="hoverRow">
                    <td data-columna="codigo">${lote["codigo"]}</td>
                    <td data-columna="peso">${lote["peso"]}</td>
                </tr>`
                    )
                    .join("")}
                    
                </tbody>
            </table>`;

    const btnVolverMapa = document.createElement("div");
    btnVolverMapa.innerHTML = "<i class='bx bx-left-arrow-alt'></i>";
    const mapaPlaceholder = document.createElement("div");
    mapaPlaceholder.id = "mapaPlaceholder";
    const ActualizarDiv = document.createElement("div");
    const btnActualizar = document.createElement("div");
    btnActualizar.textContent = "Actualizar";
    ActualizarDiv.appendChild(btnActualizar);
    mapa.appendChild(btnVolverMapa);
    mapa.appendChild(mapaPlaceholder);
    mapa.appendChild(ActualizarDiv);

    const rutas = document.createElement("div");
    const botones = document.createElement("div");

    section.appendChild(envio);
    section.appendChild(carga);
    section.appendChild(mapa);
    envio.appendChild(rutas);
    envio.appendChild(botones);

    const origen = document.createElement("div");
    const destino = document.createElement("div");

    rutas.appendChild(origen);
    rutas.appendChild(destino);

    let almacenOrigen = "Montevideo";
    let almacenDestino = "Artigas";

    origen.innerHTML = `<p>${almacenOrigen}</p><p>O</p>`;
    destino.innerHTML = `<p>${almacenDestino}</p><p>D</p>`;

    const verCarga = document.createElement("div");
    const verMapa = document.createElement("div");
    verMapa.id = "verMapa";
    // const comenzar = document.createElement("div");

    botones.appendChild(verCarga);
    botones.appendChild(verMapa);
    // botones.appendChild(comenzar);

    verCarga.textContent = "Carga";
    verMapa.textContent = "Mapa";
    // comenzar.textContent = "Comenzar";

    verCarga.addEventListener("click", () => {
        envio.style.display = "none";
        carga.style.display = "flex";
    });

    verMapa.addEventListener("click", () => {
        envio.style.display = "none";
        mapa.style.display = "flex";
    });

    // let viajeComenzado = false;
    // comenzar.addEventListener("click", () => {
    //     if (viajeComenzado) {
    //     }else{
    //         Swal.fire({
    //             title: "Seguro?",
    //             text: "Seguro que quieres comenzar el viaje?",
    //             icon: "warning",
    //             showCancelButton: true,
    //             confirmButtonColor: "#3085d6",
    //             cancelButtonColor: "#d33",
    //             confirmButtonText: "Comenzar",
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 Swal.fire({
    //                     title: "Comenzado!",
    //                     text: "Buen viaje!",
    //                     icon: "success",
    //                 }).then((result) => {
    //                     envio.style.display = "none";
    //                     mapa.style.display = "flex";
    //                     viajeComenzado = true;
    //                     comenzar.setAttribute("disabled", true);
    //                 });
    //             }
    //         });
    //     }
    // });

    const btnVolverCarga = document.getElementById("btnVolverCarga");
    btnVolverCarga.addEventListener("click", () => {
        envio.style.display = "flex";
        carga.style.display = "none";
    });

    btnActualizar.addEventListener("click", () => {
        location.reload();
    });

    btnVolverMapa.addEventListener("click", () => {
        envio.style.display = "flex";
        mapa.style.display = "none";
    });

    menu.addEventListener("click", () => {
        const sideMenu = document.getElementById("sideMenu");
        const computedStyles = window.getComputedStyle(sideMenu);
        const rightValue = computedStyles.getPropertyValue("right");

        if (rightValue === "-400px") {
            sideMenu.style.right = "0";
            menu.style.color = "var(--highlight)";
            menu.style.position = "fixed";
            menu.style.top = "auto";
            menu.style.right = "auto";
        } else {
            sideMenu.style.right = "-400px";
            menu.style.color = `${color}`;
            menu.style.position = "static";
        }
    });
} else {
    const color = "black";
    let abierto = null;
    const section = document.getElementById("section");

    const envio = document.createElement("div");
    envio.className = "envio";
    const carga = document.createElement("div");
    carga.style.display = "none";
    carga.className = "carga";
    const mapa = document.createElement("div");
    mapa.style.display = "none";
    mapa.className = "mapa";

    carga.innerHTML += `<div id='btnVolverCarga'><i class='bx bx-left-arrow-alt'></i></div><h1>Load</h1><table id="miTabla">
                <thead>
                    <tr>
                        <th class="columna" data-columna="codigo">
                            <div>
                                <p>Code</p>
                            </div>
                        </th>
                        <th class="columna" data-columna="peso">
                            <div>
                                <p>Weight</p>
                            </div>
                        </th>
                    </tr> 
                </thead>
                <tbody>
                ${lotes
                    .map(
                        (lote) =>
                            `<tr class="hoverRow">
                    <td data-columna="codigo">${lote["codigo"]}</td>
                    <td data-columna="peso">${lote["peso"]}</td>
                </tr>`
                    )
                    .join("")}
                    
                </tbody>
            </table>`;

    const btnVolverMapa = document.createElement("div");
    btnVolverMapa.innerHTML = "<i class='bx bx-left-arrow-alt'></i>";
    const mapaPlaceholder = document.createElement("div");
    mapaPlaceholder.id = "mapaPlaceholder";
    const ActualizarDiv = document.createElement("div");
    const btnActualizar = document.createElement("div");
    btnActualizar.textContent = "Refresh";
    ActualizarDiv.appendChild(btnActualizar);
    mapa.appendChild(btnVolverMapa);
    mapa.appendChild(mapaPlaceholder);
    mapa.appendChild(ActualizarDiv);

    const rutas = document.createElement("div");
    const botones = document.createElement("div");

    section.appendChild(envio);
    section.appendChild(carga);
    section.appendChild(mapa);
    envio.appendChild(rutas);
    envio.appendChild(botones);

    const origen = document.createElement("div");
    const destino = document.createElement("div");

    rutas.appendChild(origen);
    rutas.appendChild(destino);

    let almacenOrigen = "Montevideo";
    let almacenDestino = "Artigas";

    origen.innerHTML = `<p>${almacenOrigen}</p><p>O</p>`;
    destino.innerHTML = `<p>${almacenDestino}</p><p>D</p>`;

    const verCarga = document.createElement("div");
    const verMapa = document.createElement("div");
    verMapa.id = "verMapa";
    // const comenzar = document.createElement("div");

    botones.appendChild(verCarga);
    botones.appendChild(verMapa);
    // botones.appendChild(comenzar);

    verCarga.textContent = "Load";
    verMapa.textContent = "Map";
    // comenzar.textContent = "Comenzar";

    verCarga.addEventListener("click", () => {
        envio.style.display = "none";
        carga.style.display = "flex";
    });

    verMapa.addEventListener("click", () => {
        envio.style.display = "none";
        mapa.style.display = "flex";
    });

    const btnVolverCarga = document.getElementById("btnVolverCarga");
    btnVolverCarga.addEventListener("click", () => {
        envio.style.display = "flex";
        carga.style.display = "none";
    });

    btnActualizar.addEventListener("click", () => {
        location.reload();
    });

    btnVolverMapa.addEventListener("click", () => {
        envio.style.display = "flex";
        mapa.style.display = "none";
    });

    menu.addEventListener("click", () => {
        const sideMenu = document.getElementById("sideMenu");
        const computedStyles = window.getComputedStyle(sideMenu);
        const rightValue = computedStyles.getPropertyValue("right");

        if (rightValue === "-400px") {
            sideMenu.style.right = "0";
            menu.style.color = "var(--highlight)";
            menu.style.position = "fixed";
            menu.style.top = "auto";
            menu.style.right = "auto";
        } else {
            sideMenu.style.right = "-400px";
            menu.style.color = `${color}`;
            menu.style.position = "static";
        }
    });
}
