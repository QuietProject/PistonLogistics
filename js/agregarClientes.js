
$("#agregarClientes").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "./includes/addCustomer.php",
        dataType: "json",
        data: {
            RUT: document.getElementById("RUT").value,
            nombre: document.getElementById("nombre").value
        },
        success: function (e) {
            alert(e)
        }
    });

});
