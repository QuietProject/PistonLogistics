<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/styleLogin.css">
    <title>Piston Logistics</title>
</head>

<body>
    <form class="logInContainer" method="POST" action="{{ route('login') }}" >
        @csrf
        
        <img src="../Source/logoNegro.svg" alt="Icon" class="iconImage">
        <h1 class="title">Piston Logistics</h1>
        <input type="text" name="user" required placeholder="User" style="margin-top: 15%;">
        <input type="password" name="password" required placeholder="Password" style="margin-top: 5%;">
        <input type="submit" value="Log In" style="margin-top: 30%;" id="buttonLogIn">
    </form>
</body>

</html>