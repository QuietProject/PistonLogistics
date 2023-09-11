<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/styleCliente.css">
    <title>Document</title>
</head>

<body>
    <!-- QR Scanner -->
    <div class="qrContainer">
        <img src="../source/Placeholder QR.jpeg" alt="">
    </div>
    <div class="ticketInfo">
        <h1>Ticket Info Placeholder</h1>
    </div>
    <input type="button" value="Confirm" class="confirmButton">

    <!-- Ham Menu -->
    </div>
    <div class="hamMenu" id="hamMenu">
        <div class="hamMenuLine" id="hamMenuLine"></div>
        <div class="hamMenuLine" id="hamMenuLine"></div>
        <div class="hamMenuLine" id="hamMenuLine"></div>
    </div>
    <div class="sideMenu" id="sideMenu" style="right: -15vw;">
        <input type="button" id="BtnLogOut" value="Log Out" class="itemSideMenu">
    </div>
</body>

</html>
<script>
    let str = document.getElementById("sideMenu").style.getPropertyValue('right');
</script>
<script src="../javascript/scriptCliente.js"></script>