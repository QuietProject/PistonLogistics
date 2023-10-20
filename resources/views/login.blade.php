<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/styleLogin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Piston Logistics</title>
</head>

<body>
    <form class="logInContainer" method="POST" action=" {{ route('login') }} ">
        @csrf

        <div>
            <i class='bx bxs-truck'></i>
            <h1>Log In</h1>
            <i class='bx bxs-truck'></i>
        </div>

        <div>
            <input type="text" name="user" required placeholder="User" autocomplete="username">
            <input type="password" name="password" required placeholder="Password">
        </div>
        <div>
            <input type="submit" value="Log In" id="buttonLogIn">
        </div>
    </form>
</body>

</html>