<?php
session_start();

if (!isset($_SESSION["signin"])) {
    header("Location: ../signin");
    exit;
}

require '../config/functions.php';
$result = mysqli_query($db, "SELECT id FROM admin WHERE
    id = 1");
$row = mysqli_fetch_assoc($result);

if (!$row['id']) {
    header("Location: ../collection");
    exit;
}

if (isset($_POST["action"])) {

    if ($_POST["book-action"] == "upload") {
        $Warning = addBook($_POST);
    }

    if ($_POST["book-action"] == "edit") {
        $Warning = editBook($_POST);
    }
}

if (isset($_POST["delete"])) {
    $Warning_del = delBook($_POST);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aksara Diskret">
    <title>Admin | Aksara Diskret</title>
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
            <a class="back" href="../collection/"><img src="../assets/icon/remixicon-arrow-left-line.svg" alt="Back Icon"></a>
            <h1>Admin Area</h1>
            <form class="admin" method="post" enctype="multipart/form-data">
                <h2>Upload or Edit a book</h2>
                <p>Cover image (<b>png, jpg,</b> & <b>jpeg</b>) max size <b>24MB</b> & min resolution <b>2000</b> x <b>3000</b> pixels or <b>2:3</b> aspect ratio :</p>
                <input name="cover" type="file" class="rounded-box" accept="image/png, image/jpeg" required>
                <p>Book file (<b>pdf</b>) max size <b>720MB</b> :</p>
                <input name="book" type="file" class="rounded-box" accept="application/pdf" required>
                <input name="isbn" type="number" id="book-isbn" class="rounded-box" placeholder="ISBN" required>
                <input name="title" type="text" id="book-title" class="rounded-box" placeholder="Title" required>
                <input name="author" type="text" id="book-author" class="rounded-box" placeholder="Author" required>
                <p>Choose an action :</p>
                <select name="book-action" id="book-action" class="rounded-box" required>
                    <option selected="selected" disabled="disabled" value="">Please Select</option>
                    <option value="upload">Upload</option>
                    <option value="edit">Edit</option>
                </select>
                <div class="check-box">
                    <input type="checkbox" id="action-confirm" onclick="actionConfirm()">
                    <label for="action-confirm">I am fully responsible for the book that I upload from any unwanted
                        things that might happen later.</label>
                </div>
                <?php if (isset($Warning)) {
                    echo $Warning;
                } ?>
                <button name="action" type="submit" id="action-btn" class="rounded-box primary-btn" disabled>Confirm Action</button>
                <hr>
            </form>
            <form class="admin" method="post">
                <h2>Delete a book</h2>
                <input name="delISBN" type="number" id="book-isbn" class="rounded-box" placeholder="ISBN" required>
                <div class="check-box">
                    <input type="checkbox" id="delete-confirm" onclick="deleteConfirm()">
                    <label for="delete-confirm">Confirm to delete the book.</label>
                </div>
                <?php if (isset($Warning_del)) {
                    echo $Warning_del;
                } ?>
                <button name="delete" type="submit" id="delete-btn" class="rounded-box primary-btn" disabled>Delete Book</button>
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