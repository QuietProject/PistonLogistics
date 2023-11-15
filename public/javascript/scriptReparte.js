if (document.documentElement.lang === "es") {
    const color = "black";
    const section = document.getElementById("section");

    const envio = document.createElement("div");
    envio.className = "envio";
    envio.id = "envio";
    const carga = document.createElement("div");
    carga.id = "carga";
    carga.style.display = "none";
    carga.className = "carga";
    const mapa = document.createElement("div");
    mapa.style.display = "none";
    mapa.className = "mapa";
    const entregar = document.createElement("div");
    entregar.style.display = "none";
    entregar.className = "mapa";

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

    const btnVolverEntregar = document.createElement("div");
    btnVolverEntregar.innerHTML = "<i class='bx bx-left-arrow-alt'></i>";
    entregar.appendChild(btnVolverEntregar);

    var rutas = document.createElement("div");
    const botones = document.createElement("div");

    section.appendChild(envio);
    section.appendChild(carga);
    section.appendChild(mapa);
    section.appendChild(entregar);
    envio.appendChild(rutas);
    envio.appendChild(botones);

    const verCarga = document.createElement("div");
    const verMapa = document.createElement("div");
    const entregarPaquete = document.createElement("div");
    verMapa.id = "verMapa";

    botones.appendChild(verCarga);
    botones.appendChild(verMapa);
    botones.appendChild(entregarPaquete);

    verCarga.textContent = "Carga";
    verMapa.textContent = "Mapa";
    entregarPaquete.textContent = "Entregar Paquete";

    verCarga.addEventListener("click", () => {
        envio.style.display = "none";
        carga.style.display = "flex";
    });

    verMapa.addEventListener("click", () => {
        envio.style.display = "none";
        mapa.style.display = "flex";
    });

    entregarPaquete.addEventListener("click", () => {
        envio.style.display = "none";
        entregar.style.display = "flex";
    });

    btnActualizar.addEventListener("click", () => {
        location.reload();
    });

    btnVolverMapa.addEventListener("click", () => {
        envio.style.display = "flex";
        mapa.style.display = "none";
    });

    btnVolverEntregar.addEventListener("click", () => {
        envio.style.display = "flex";
        entregar.style.display = "none";
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
    const section = document.getElementById("section");

    const envio = document.createElement("div");
    envio.className = "envio";
    envio.id = "envio";
    const carga = document.createElement("div");
    carga.id = "carga";
    carga.style.display = "none";
    carga.className = "carga";
    const mapa = document.createElement("div");
    mapa.style.display = "none";
    mapa.className = "mapa";
    const entregar = document.createElement("div");
    entregar.style.display = "none";
    entregar.className = "mapa";

    const btnVolverMapa = document.createElement("div");
    btnVolverMapa.innerHTML = "<i class='bx bx-left-arrow-alt'></i>";
    const mapaPlaceholder = document.createElement("div");
    mapaPlaceholder.id = "mapaPlaceholder";
    const ActualizarDiv = document.createElement("div");
    const btnActualizar = document.createElement("div");
    btnActualizar.textContent = "Refresh Map";
    ActualizarDiv.appendChild(btnActualizar);
    mapa.appendChild(btnVolverMapa);
    mapa.appendChild(mapaPlaceholder);
    mapa.appendChild(ActualizarDiv);

    const btnVolverEntregar = document.createElement("div");
    btnVolverEntregar.innerHTML = "<i class='bx bx-left-arrow-alt'></i>";
    entregar.appendChild(btnVolverEntregar);

    var rutas = document.createElement("div");
    const botones = document.createElement("div");

    section.appendChild(envio);
    section.appendChild(carga);
    section.appendChild(mapa);
    section.appendChild(entregar);
    envio.appendChild(rutas);
    envio.appendChild(botones);

    const verCarga = document.createElement("div");
    const verMapa = document.createElement("div");
    const entregarPaquete = document.createElement("div");
    verMapa.id = "verMapa";

    botones.appendChild(verCarga);
    botones.appendChild(verMapa);
    botones.appendChild(entregarPaquete);

    verCarga.textContent = "Load";
    verMapa.textContent = "Map";
    entregarPaquete.textContent = "Deliver Package";

    verCarga.addEventListener("click", () => {
        envio.style.display = "none";
        carga.style.display = "flex";
    });

    verMapa.addEventListener("click", () => {
        envio.style.display = "none";
        mapa.style.display = "flex";
    });

    entregarPaquete.addEventListener("click", () => {
        envio.style.display = "none";
        entregar.style.display = "flex";
    });

    btnActualizar.addEventListener("click", () => {
        location.reload();
    });

    btnVolverMapa.addEventListener("click", () => {
        envio.style.display = "flex";
        mapa.style.display = "none";
    });

    btnVolverEntregar.addEventListener("click", () => {
        envio.style.display = "flex";
        entregar.style.display = "none";
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
