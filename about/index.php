<?php

session_start();

if (isset($_SESSION["signin"])) {
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
    <title>About | Aksara Diskret</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/text.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Caveat&display=swap" rel="stylesheet">

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
            <h1>All About Us</h1>
            <div class="content about">
                <div class="item">
                    <h2>What is Aksara Diskret?</h2>
                    <p>Is an online library that offers a wide variety of books.</p>
                </div>
                <div class="item">
                    <h2>Project Presentation</h2>
                    <a href="https://drive.google.com/drive/folders/1MwTR6dBGgnmQBqwb2W4NQu-GCC-7SzQ1?usp=share_link" target="_blank" class="link">Google Drive</a>
                </div>
                <div class="item teams">
                    <h2>Our Teams :</h2>
                    <ul>
                        <li class="rounded-box">
                            <div class="team-role">UI Designer</div>
                            <b>Daniel Rompas</b>
                            <p class="nim">20021106052</p>
                        </li>
                        <li class="rounded-box">
                            <div class="team-role">Frontend Engineer</div>
                            <b>Rezky Wahyudi Mokobombang</b>
                            <p class="nim">210211060165</p>
                        </li>
                        <li class="rounded-box">
                            <div class="team-role">Backend Engineer</div>
                            <b>Muhammat Rizky Saria</b>
                            <p class="nim">210211060100</p>
                        </li>
                    </ul>
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