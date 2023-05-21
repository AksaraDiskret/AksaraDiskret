<?php

session_start();

if (isset($_SESSION["signin"]) || isset($_SESSION["signinUser"]) || isset($_COOKIE["secret"])) {
    $user_link = "../signout";
    $user_status = "Sign Out";
} else {
    $user_link = "../signin";
    $user_status = "Sign In";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aksara Diskret">
    <title>FAQ | Aksara Diskret</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/text.css">
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
                <li><a href="<?= $user_link ?>" class="rounded-box btn nav-btn"><?= $user_status ?></a></li>
            </ul>
        </nav>
        <div id="nav-icon" onclick="mobileNav()">
            <img id="menu-icon" src="../assets/icon/remixicon-menu-5-line.svg" alt="Menu Icon">
            <img id="close-icon" src="../assets/icon/remixicon-close-line.svg" alt="Close Icon">
        </div>
    </header>
    <div class="app-container">
        <main>
            <h1>Frequently Asked Questions</h1>
            <div class="content">
                <div class="item">
                    <h2>Are book on this site is legal?</h2>
                    <p>Yes, if the books are in the public domain or have permission from the author or publisher.
                        Downloading copyrighted books without permission is illegal.</p>
                </div>
                <div class="item">
                    <h2>Can I find all types of books on this site?</h2>
                    <p>We provide books in general and don't stick to one type. but mostly about technology.</p>
                </div>
                <div class="item">
                    <h2>Are there any risks associated with downloading books from our site?</h2>
                    <p>It's possible, but we try to check every book received here and it is safe enough to download.
                    </p>
                </div>
                <div class="item">
                    <h2>What is our motivation for building this website?</h2>
                    <p>
                        With books, everyone has the right to dig and feel the depth of the well of knowledge. does not only apply to those who have material advantages.
                    </p>
                </div>
            </div>
        </main>
        <footer>
            <p>Copyright ©️ 2023 <b>Aksara Diskret</b>.</p>
            <p>Made with ❤️ by <b>AD</b> Team.</p>
        </footer>
    </div>
    <script src="../js/main.js"></script>
</body>

</html>