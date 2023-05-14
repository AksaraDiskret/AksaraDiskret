<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aksara Diskret">
    <title>Admin | Aksara Diskret</title>
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="/css/mform.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="/assets/favicon/ad-light.svg" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/svg+xml" href="/assets/favicon/ad-dark.svg" media="(prefers-color-scheme: light)">
</head>

<body>
    <header>
        <a href="/"><img src="/assets/icon/ad-logo.svg" alt="Aksara Diskret Logo"></a>
        <nav>
            <ul id="nav-list">
                <li><a href="/collection">Books Collection</a></li>
                <li><a href="/faq">FAQ</a></li>
                <li><a href="/about">About</a></li>
                <li id="close-icon" onclick="closeMenu()">
                    <img src="/assets/icon/remixicon-close-line.svg" alt="Close Icon">
                </li>
            </ul>
        </nav>
        <div id="menu-icon" onclick="showMenu()"><img src="/assets/icon/remixicon-menu-5-line.svg" alt="Menu Icon">
        </div>
    </header>
    <div class="app-container">
        <main>
            <h1>Admin restricted area</h1>
            <form class="admin">
                <h2>Upload or Edit a book</h2>
                <p>Cover, minimum size 3000 x 2000 pixel or 3:2 aspect ratio :</p>
                <input type="file" class="rounded-box" accept="image/png, image/jpeg">
                <p>File, only accept PDF file :</p>
                <input type="file" class="rounded-box" accept="application/pdf">
                <input type="text" id="book-isbn" class="rounded-box" placeholder="ISBN">
                <input type="text" id="book-title" class="rounded-box" placeholder="Title">
                <input type="text" id="book-author" class="rounded-box" placeholder="Author">
                <p>Choose an action :</p>
                <select name="book-action" id="book-action" class="rounded-box">
                    <option value="upload">Upload</option>
                    <option value="edit">Edit</option>
                </select>
                <div class="check-box">
                    <input type="checkbox" id="action-confirm" onclick="actionConfirm()">
                    <label for="action-confirm">I am fully responsible for the book that I upload from any unwanted
                        things that might happen later.</label>
                </div>
                <button type="button" id="action-btn" class="rounded-box primary-btn" onclick="confirmAction()"
                    disabled>Confirm Action</button>
                <span class="success">Book uploaded / Book edited.</span>
                <hr>
                <h2>Delete a book</h2>
                <input type="text" id="book-identifier" class="rounded-box" placeholder="Book ISBN, Title, or the Author">
                <div class="check-box">
                    <input type="checkbox" id="delete-confirm" onclick="deleteConfirm()">
                    <label for="delete-confirm">Confirm to delete the book.</label>
                </div>
                <button type="button" id="delete-btn" class="rounded-box primary-btn" onclick="deleteBook()"
                    disabled>Delete Book</button>
                <span class="success">Book deleted.</span>
                <hr>
            </form>
        </main>
        <footer>
            <p>Copyright ©️ 2023 <b>Aksara Diskret</b>.</p>
            <p>Made with ❤️ by <b>AD</b> Team.</p>
        </footer>
    </div>
    <script src="/js/main.js"></script>
</body>

</html>