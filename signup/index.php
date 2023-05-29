<?php

session_start();
require "../config/functions.php";

if (isset($_SESSION["signin"]) || isset($_SESSION["signinUser"])) {

    header("Location: ../collection");
    exit;
}

if (isset($_POST["submit"])) {
    $notif = addUser($_POST);
}


?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aksara Diskret">
    <title>Sign Up | Aksara Diskret</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/mform.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="../assets/favicon/ad-light.svg" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/svg+xml" href="../assets/favicon/ad-dark.svg" media="(prefers-color-scheme: light)">
</head>

<body>
    <header>
        <a href="../"><img src="../assets/icon/ad-logo.svg" alt="Aksara Diskret Logo"></a>
        <nav>
            <ul id="nav-list">
                <li><a href="../faq">FAQ</a></li>
                <li><a href="../about">About</a></li>
            </ul>
        </nav>
        <div id="nav-icon" onclick="mobileNav()">
            <img id="menu-icon" src="../assets/icon/remixicon-menu-5-line.svg" alt="Menu Icon">
            <img id="close-icon" src="../assets/icon/remixicon-close-line.svg" alt="Close Icon">
        </div>
    </header>
    <div class="app-container">
        <main>
            <h1>Sign Up to Get Started</h1>

            <form  method="post">
                <input type="text" name="first_name" id="first-name" class="rounded-box" placeholder="First Name" required>
                <input type="text" name="last_name" id="last-name" class="rounded-box" placeholder="Last Name" required>
                <input type="email" name="email" class="rounded-box" placeholder="Email Address" required>
                <div class="pass-box">

                    <input type="password" name="password" class="rounded-box default-password" placeholder="Password" required>
                    <img id="h-default-pass" src="../assets/icon/remixicon-eye-line.svg" alt="Hide Password Icon">
                    <img id="s-default-pass" src="../assets/icon/remixicon-eye-off-line.svg" alt="Show Password Icon">

                </div>
                <?php if (isset($notif)) {
                    echo $notif;
                } ?>
                <button type="submit" class="rounded-box primary-btn" id="data-btn" name="submit">Sign
                    Up</button>
                <p class="user-note">Already have an Account? <a href="../signin" class="link">Sign In</a></p>
            </form>
        </main>
        <footer>
            <p>Copyright ©️ 2023 <b>Aksara Diskret</b>.</p>
            <p>Made with ❤️ by <b>AD</b> Team.</p>
        </footer>
    </div>
    <script src="../js/main.js"></script>
</body>

</html>