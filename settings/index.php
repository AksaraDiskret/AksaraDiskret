<?php
session_start();



if (!isset($_SESSION["signin"]) && !isset($_SESSION["signinUser"]) && !isset($_COOKIE["signin"])) {
    header("Location: ../signin");
    exit;
}


require "../config/functions.php";

if (isset($_POST["change_email"])) {
    $warning_email = ChangeEmail($_POST);
}

if (isset($_POST["change_pass"])) {
    $warning_pass = ChangePass($_POST);
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
                <li>
                    <?php if (FeaturePrevilage()) : ?>
                        <a href="../admin">Admin</a>
                    <?php endif; ?>
                </li>
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
            <a class="back" href="../collection/"><img src="../assets/icon/remixicon-arrow-left-line.svg" alt="Back Icon"></a>
            <h1>Settings your account</h1>
            <form method="post">
                <h2>Change your email</h2>
                <input type="email" name="new_email" id="new-email" class="rounded-box" placeholder="New Email Address" required>
                <?php if (isset($warning_email)) : ?>
                    <?= $warning_email ?>
                <?php endif; ?>
                <button type="submit" name="change_email" class="rounded-box primary-btn">Change Email</button>
                <hr>
            </form>
            <form method="post">
                <h2>Change your password</h2>
                <div class="pass-box">
                    <input type="password" name="old-password" class="rounded-box old-password" placeholder="Old Password" required>
                    <img id="h-old-pass" src="../assets/icon/remixicon-eye-line.svg" alt="Hide Password Icon">
                    <img id="s-old-pass" src="../assets/icon/remixicon-eye-off-line.svg" alt="Show Password Icon">
                </div>
                <div class="pass-box">
                    <input type="password" name="new-password" class="rounded-box default-password" placeholder="New Password" required>
                    <img id="h-default-pass" src="../assets/icon/remixicon-eye-line.svg" alt="Hide Password Icon">
                    <img id="s-default-pass" src="../assets/icon/remixicon-eye-off-line.svg" alt="Show Password Icon">
                </div>
                <button type="submit" name="change_pass" class="rounded-box primary-btn">Change Password</button>
                <?php if (isset($warning_pass)) {
                    echo $warning_pass;
                } ?>
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