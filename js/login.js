$("#iniciar").submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "./includes/login.php",
        dataType: "json",
        data: {
            pwd: document.getElementById("pwd").value,
            usuario: document.getElementById("usuario").value
        },
        success: function(e) {
            console.log(e)
            if (e == "success") {
                window.location = "./"
            } else {
                alert(e)
            }
        }
    });
});