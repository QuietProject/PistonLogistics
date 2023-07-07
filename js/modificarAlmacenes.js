
$("#modificarAlmacenes").submit(function (e) {
    e.preventDefault();
    const parametros = new URLSearchParams(window.location.search);
    const id =parametros.get('id');
    console.log('entra')
    $.ajax({
        type: "post",
        url: "./includes/editDepot.php",
        //dataType: "json",
        data: {
            nombre: document.getElementById("nombre").value,
            calle: document.getElementById("calle").value,
            numero: document.getElementById("numero").value,
            id: id
        },
        success: function (e) {
            alert(e)
        }
    });

});