const color = "white";

const btnSubmit = document.getElementById("btnSubmit");
const miFormulario = document.getElementById("form");

if (document.documentElement.lang === "es") {
    btnSubmit.addEventListener("click", (e) => {
        if (!miFormulario.checkValidity()) {
            return;
        } else {
            e.preventDefault();
            Swal.fire({
                title: "¿Seguro?",
                text: "No se podran revertir los cambios",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Asignar peso",
            }).then((result) => {
                if (result.isConfirmed) {
                    miFormulario.submit();
                }
            });
        }
    });
} else {
    btnSubmit.addEventListener("click", (e) => {
        if (!miFormulario.checkValidity()) {
            return;
        } else {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Assign weight",
            }).then((result) => {
                if (result.isConfirmed) {
                    miFormulario.submit();
                }
            });
        }
    });
}
