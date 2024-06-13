document.getElementById('changePass').addEventListener('change', function (e) {
    let pass = document.getElementById('passDiv');
    if (e.target.checked) {
        pass.removeAttribute('hidden')
    } else {
        pass.setAttribute('hidden', '')
    }
});


$("#modificarUsuarios").submit(function (e) {
    e.preventDefault();
    const parametros = new URLSearchParams(window.location.search);
    const id =parametros.get('id');
    $.ajax({
        type: "post",
        url: "./includes/editUser.php",
        dataType: "json",
        data: {
            id: id,
            usuario: document.getElementById("user").value,
            nombre: document.getElementById("nombre").value,
            apellido: document.getElementById("apellido").value,
            celular: document.getElementById("celular").value,
            licencia: document.getElementById("licencia").value,
            changePass: document.getElementById('changePass').checked,
            pass: document.getElementById("pass").value
        },
        success: function (e) {
            alert(e)
        }
    });

});
