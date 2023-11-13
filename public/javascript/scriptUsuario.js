document.getElementById("tipo").addEventListener("change", function () {
    var e = document.getElementById("tipo")
    var value = e.value
    var ciInput = document.getElementById("ciInput")
    var camioneroInput = document.getElementById("camioneroInput")
    var clienteInput = document.getElementById("clienteInput")
    var almacenClienteInput = document.getElementById("almacenClienteInput")
    var almacenPropioInput = document.getElementById("almacenPropioInput")
    var emailInput = document.getElementById("emailInput")

    if (value == 0) {
        ciInput.style.display = "flex"
        camioneroInput.style.display = "none"
        clienteInput.style.display = "none"
        almacenClienteInput.style.display = "none"
        almacenPropioInput.style.display = "none"
        emailInput.style.display = "flex"
    }
    if (value == 1) {
        ciInput.style.display = "flex"
        camioneroInput.style.display = "none"
        clienteInput.style.display = "none"
        almacenClienteInput.style.display = "none"
        almacenPropioInput.style.display = "flex"
        emailInput.style.display = "flex"
    }
    if (value == 2) {
        ciInput.style.display = "none"
        camioneroInput.style.display = "flex"
        clienteInput.style.display = "none"
        almacenClienteInput.style.display = "none"
        almacenPropioInput.style.display = "none"
        emailInput.style.display = "flex"
    }
    if (value == 3) {
        ciInput.style.display = "none"
        camioneroInput.style.display = "none"
        clienteInput.style.display = "none"
        almacenClienteInput.style.display = "flex"
        almacenPropioInput.style.display = "none"
        emailInput.style.display = "flex"
    }
})
