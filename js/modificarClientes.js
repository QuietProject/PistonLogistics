$("#modificarClientes").submit(function (e) {
    e.preventDefault();
    const parametros = new URLSearchParams(window.location.search);
    const rut =parametros.get('rut');
    $.ajax({
        type: "post",
        url: "./includes/editCustomer.php",
        dataType: "json",
        data: {
            oldRut: rut,
            rut: document.getElementById("RUT").value,
            nombre: document.getElementById("nombre").value
        },
        success: function (e) {
            console.log(e)
        }
    });

});
