const color = "white";

const btnSubmit = document.getElementById("btnSubmit");
const miFormulario = document.getElementById("form");

btnSubmit.addEventListener("click", (e) => {
    if (!miFormulario.checkValidity()) {
        return;
    }else{
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

