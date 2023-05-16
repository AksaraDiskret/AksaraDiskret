<?php
session_start();
require "../functions/functions.php";

if (isset($_POST["ganti_email"]) || isset($_POST["ganti_password"])) {
    $iduser = mysqli_query($db, "SELECT id FROM users");
    $warning = Change($_POST);
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aksara Diskret">
    <title>Settings | Aksara Diskret</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/mform.css">
    <link rel="stylesheet" href="../css/settings.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="../assets/favicon/ad-light.svg" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/svg+xml" href="../assets/favicon/ad-dark.svg" media="(prefers-color-scheme: light)">
</head>

<body>
    <header>
        <a href="/"><img src="../assets/icon/ad-logo.svg" alt="Aksara Diskret Logo"></a>
        <nav>
            <ul id="nav-list">
                <li><a href="../admin/index.html">Admin</a></li>
                <li><a href="../faq/index.html">FAQ</a></li>
                <li><a href="../about/index.html">About</a></li>
                <li id="close-icon" onclick="closeMenu()">
                    <img src="../assets/icon/remixicon-close-line.svg" alt="Close Icon">
                </li>
            </ul>
        </nav>
        <div id="menu-icon" onclick="showMenu()"><img src="../assets/icon/remixicon-menu-5-line.svg" alt="Menu Icon">
        </div>
    </header>
    <div class="app-container">
        <main>
            <div class="setting">
                <a href="../collection/index.html"><img src="../assets/icon/remixicon-arrow-left-line.svg" alt="Back Icon"></a>
                <h1>Settings your account</h1>
            </div>
            <form action="" method="post">
                <h2>Change your email</h2>

                <input type="email" id="new-email" class="rounded-box" name="new_email" placeholder="New Email Address">
                <button type="submit" name="ganti_email" class="rounded-box primary-btn">Change
                    Email</button>
                <span class="success">Email Address changed.</span>
                <hr>
                <h2>Change your password</h2>
                <input type="password" name="new_password" id="newpassword" class="rounded-box password" placeholder="New Password">
                <input type="password" name="old_password" id="oldpassword" class="rounded-box password" placeholder="Old Password">
                <div class="check-box">
                    <input type="checkbox" id="show-password" onclick="showPassword()">
                    <label for="show-password">Show Password</label>
                </div>
                <button type="submit" name="ganti_password" class="rounded-box primary-btn">Change
                    Password</button>
                <span class="success">Password changed.</span>
                <hr>
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