const color = "white";

document.addEventListener("DOMContentLoaded", function () {
    const tipoSelect = document.getElementById("tipo");
    const ordenSelect = document.getElementById("orden");
    const linea = document.getElementById("linea");
    const almacenDestinoTitulo = document.getElementById(
        "almacenDestinoTitulo"
    );

    function toggleOrdenSelectVisibility() {
        if (tipoSelect.value === "1") {
            ordenSelect.style.display = "none";
            ordenSelect.value = "default";
            almacenDestinoTitulo.textContent = "";
            linea.style.display = "none";
            ordenSelect.removeAttribute("required");
        } else {
            ordenSelect.style.display = "block";
            almacenDestinoTitulo.textContent = "Almacen Destino";
            linea.style.display = "block";
            ordenSelect.setAttribute("required", "required");
        }
    }

    tipoSelect.addEventListener("change", toggleOrdenSelectVisibility);
});

const btnSubmit = document.getElementById("btnSubmit");
const miFormulario = document.getElementById("form");

btnSubmit.addEventListener("click", (e) => {
    if (!miFormulario.checkValidity()) {
        return;
    }else{
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then((result) => {
            if (result.isConfirmed) {
                miFormulario.submit();
            }
          });
    }
});

