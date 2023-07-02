document.getElementById('rol').addEventListener('change', function (e) {
    let licencia = document.getElementById('divLicencia');
    if (e.target.value == '2') {
        licencia.removeAttribute('hidden')
    } else{
        licencia.setAttribute('hidden','')
    }
});

$("#agregarUsuarios").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "./includes/addUser.php",
        //dataType: "json",
        data: {
            usuario: document.getElementById("user").value,
            pass: document.getElementById("pass").value,
            nombre: document.getElementById("nombre").value,
            apellido: document.getElementById("apellido").value,
            celular: document.getElementById("celular").value,
            rol: document.getElementById("rol").value,
            licencia: document.getElementById("licencia").value
        },
        success: function (e) {
            alert(e)
        }
    });

});
