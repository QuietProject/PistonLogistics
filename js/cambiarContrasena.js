$("#cambiar").submit(function (e) {
    e.preventDefault();
    let pwd = document.getElementById("pwd").value;
    let pwdRepeat = document.getElementById("pwdRepeat").value;

    if (pwd != pwdRepeat) {
        alert('Las contraseñas no coinciden');
        return;
    }
    $.ajax({
        type: "post",
        url: "./includes/changePwd.php",
        dataType: "json",
        data: {
            pwd: pwd,
            pwdRepeat: pwdRepeat
        },
        success: function (e) {
            console.log(e)
            if (e == "success") {
                window.location = "./"
            } else {
                alert(e)
            }
        }
    });
});