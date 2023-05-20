<?php

session_start();

if (isset($_SESSION["signin"]) || isset($_SESSION["signinUser"]) || isset($_COOKIE["secret"])) {
    $user_link = "signout";
    $user_status = "Sign Out";
    $user_link_primary = "collection";
    $user_link_status = "Books Collection";
} else {
    $user_link = "signin";
    $user_status = "Sign In";
    $user_link_primary = "signup";
    $user_link_status = "Get Started";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aksara Diskret">
    <title>Aksara Diskret | Online Books Library</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="assets/favicon/ad-light.svg" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/svg+xml" href="assets/favicon/ad-dark.svg" media="(prefers-color-scheme: light)">

</head>

<body>
    <header>
        <a href="."><img src="assets/icon/ad-logo.svg" alt="Aksara Diskret Logo"></a>
        <nav>
            <ul id="nav-list">
                <li><a href="faq">FAQ</a></li>
                <li><a href="about">About</a></li>
                <li><a href="<?= $user_link ?>" class="rounded-box btn nav-btn"><?= $user_status ?></a></li>
            </ul>
        </nav>
        <div id="nav-icon" onclick="mobileNav()">
            <img id="menu-icon" src="assets/icon/remixicon-menu-5-line.svg" alt="Menu Icon">
            <img id="close-icon" src="assets/icon/remixicon-close-line.svg" alt="Close Icon">
        </div>

    </header>
    <div class="app-container">
        <main>
            <div class="primary-content">
                <h1>Discover Our Extensive Collection of Books</h1>
                <p>Find your next favorite book in our collections.</p>
                <a href="<?= $user_link_primary ?>" class="rounded-box btn primary-btn get-start"><?= $user_link_status ?></a>
            </div>
            <img src="assets/image/sketchvalley-learningexpress.png" alt="a magnifying glass highlights a globe and some books" class="main-img">

        </main>
        <footer>
            <p>Copyright ©️ 2023 <b>Aksara Diskret</b>.</p>
            <p>Made with ❤️ by <b>AD</b> Team.</p>
        </footer>
    </div>
    <script src="js/main.js"></script>
</body>

</html>