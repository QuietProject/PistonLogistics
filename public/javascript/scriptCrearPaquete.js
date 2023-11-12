const color = "white";

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
