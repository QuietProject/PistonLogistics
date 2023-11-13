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
    
            if (columnaSeleccionada !== "cedula") {
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
    
    const btnEntregar = document.querySelectorAll(".btnEntregar");

    btnEntregar.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const route = btn.getAttribute("data-route");

            e.preventDefault();

            Swal.fire({
                title: "¿Seguro?",
                text: "No podras revertir este cambio",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aprontar",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = route;
                }
            });
        });
    });
}else{

}
