<?php
session_start();
$db = mysqli_connect("localhost", "akad8679_ad", "akad8679_ad", "akad8679_ad");
function rowData($result)
{
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function cookieCheck()
{
    global $db;
    if (isset($_COOKIE['signin']) && isset($_COOKIE['secret'])) {
        $signin = $_COOKIE['signin'];
        $secret = $_COOKIE['secret'];
        $result = mysqli_query($db, "SELECT email FROM users WHERE id = '$signin'");
        $row = mysqli_fetch_assoc($result);
        if ($secret === hash('sha512', $row['email'])) {
            $_SESSION["signInUser"] = true;
            $_SESSION["idUser"] = $signin;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function emailCheck($email)
{
    global $db;
    $result = mysqli_query($db, "SELECT email FROM users WHERE email = '$email'");
    $isReg = rowData($result);
    return ($isReg) ? true : false;
}
function isbnCheck($isbn)
{
    global $db;
    $result = mysqli_query($db, "SELECT isbn FROM books WHERE isbn = '$isbn'");
    $isUse = rowData($result);
    return ($isUse) ? true : false;
}
function photoCheck($id)
{
    global $db;
    $result = mysqli_query($db, "SELECT picture from users WHERE id = '$id' AND picture = 'default.png'");
    $isDefault = mysqli_fetch_assoc($result);
    return ($isDefault) ? true : false;
}
function signinCheck($email, $pass)
{
    global $db;
    $result = mysqli_query($db, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($result) === 1) {
        $userData = mysqli_fetch_assoc($result);
        if (password_verify($pass, $userData["password"])) {
            $_SESSION["signInUser"] = true;
            $_SESSION["idUser"] = $userData["id"];
            if (isset($_POST['remember-me'])) {
                setcookie('signin', $userData["id"], time() + 1800, '/');
                setcookie('secret', hash('sha512', $userData["email"]), time() + 1800, '/');
            } else {
                header("Location: ../collections");
                exit();
            }
            header("Location: ../collections");
            exit();
        } else {
            return '<span class="failed">Your Password is wrong.</span>';
        }
    } else {
        return '<span class="failed">Email address is not registered.</span>';
    }
}
function addUser($data)
{
    global $db;
    $first_name = htmlspecialchars($data["first_name"]);
    $last_name = htmlspecialchars($data["last_name"]);
    $email = htmlspecialchars($data["email"]);
    $password = htmlspecialchars($data["password"]);
    if (!preg_match("/^(?!.*['-]{2})[a-zA-Z][a-zA-Z'\s-]{1,85}$/", $first_name) || !preg_match("/^(?!.*['-]{2})[a-zA-Z][a-zA-Z'\s-]{1,85}$/", $last_name)) {
        return '<span class="failed">Please enter the appropriate Name & contains letter only.</span>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return '<span class="failed">Please enter a valid Email format.</span>';
    } elseif (emailCheck($email)) {
        return '<span class="failed">Email address is already registered. Please use another one.</span>';
    } elseif (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password)) {
        return '<span class="failed">Password must be at least, 8 characters long, one uppercase, <br>one lowercase, one digit, and one special character.</span>';
    } else {
        $password =  password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($db, "INSERT INTO users VALUES ('','default.png', '$first_name','$last_name','$email','$password')");
        return '<span class="success">Sign Up is successfully.</span>';
    }
}
function bookAction($data)
{
    global $db;
    $isbn = htmlspecialchars($data["isbn"]);
    $title = $data["title"];
    $author = htmlspecialchars($data["author"]);
    $id = mysqli_query($db, "SELECT id from books WHERE isbn = '$isbn'");
    $users = mysqli_fetch_assoc($id);
    if (!ctype_digit($isbn) || strlen($isbn) != 13) {
        return '<span class="failed">ISBN must be a number only & with length of 13 digit.</span>';
    } elseif (!preg_match("/^[\w\s\d'\-]+$/", $title)) {
        return '<span class="failed">Please enter the appropriate Title, it contains letter, apostrof, dash, & numbers only.</span>';
    } elseif (!preg_match("/^(?!.*['-]{2})[a-zA-Z][a-zA-Z'\s-]{1,85}$/", $author)) {
        return '<span class="failed">Please enter the appropriate author Name & contains letter only.</span>';
    } elseif (!isset($_POST["book-action"])) {
        return '<span class="failed">Please choose a action.</span>';
    } elseif (isset($data["confirm-action"])) {
        if ($_POST["book-action"] == "edit") {
            if (!isbnCheck($isbn)) {
                return "<span class='failed'>ISBN is not found or has been deleted.</span>";
            } elseif ($_SESSION["idUser"] !== $users["id"]) {
                return "<span class='failed'>Can not be edited. You are not the uploader.</span>";
            } else {
                editBook($data);
                return '<span class="success">Book is edited.</span>';
            }
        } elseif ($_POST["book-action"] == "upload") {
            if (isbnCheck($isbn)) {
                return '<span class="failed">Book with this ISBN already exists.</span>';
            } elseif (is_uploaded_file($_FILES['cover']['tmp_name']) && is_uploaded_file($_FILES['book']['tmp_name'])) {
                $mimeTypeCover = mime_content_type($_FILES['cover']['tmp_name']);
                $mimeTypeBook = mime_content_type($_FILES['book']['tmp_name']);
                $fileTypesCover = ['image/png', 'image/jpg', 'image/jpeg'];
                $fileTypesBook = ['application/pdf'];
                if (!in_array($mimeTypeCover, $fileTypesCover) && !in_array($mimeTypeBook, $fileTypesBook)) {
                    return '<span class="failed">Not a supported file types.</span>';
                } elseif ($_FILES['cover']['size'] > 4200000) {
                    return '<span class="failed">Image size is too big.</span>';
                } elseif ($_FILES['book']['size'] > 68000000) {
                    return '<span class="failed">PDF size is too big.</span>';
                } else {
                    uploadBook($data);
                    return '<span class="success">Book is uploaded.</span>';
                }
            } else {
                return '<span class="failed">Please choose a files to upload.</span>';
            }
        } else {
            return '<span class="failed">None of the options match.</span>';
        }
    } else {
        return '<span class="failed">Agreement confirmation has not been checked.</span>';
    }
}
function editBook($data)
{
    global $db;
    $isbn = htmlspecialchars($data["isbn"]);
    $title = htmlspecialchars($data["title"]);
    $author = htmlspecialchars($data["author"]);
    mysqli_query($db, "UPDATE books SET title = '$title' WHERE isbn = '$isbn' ");
    mysqli_query($db, "UPDATE books SET author = '$author' WHERE isbn = '$isbn'");
}
function uploadBook($data)
{
    global $db;
    $id = $_SESSION["idUser"];
    $isbn = htmlspecialchars($data["isbn"]);
    $title = htmlspecialchars($data["title"]);
    $author = htmlspecialchars($data["author"]);
    $fileName = uploadFiles();
    $cover = $fileName['cover'];
    $book = $fileName['book'];
    mysqli_query($db, "INSERT INTO books VALUES ('$cover','$book','$isbn','$id','$title','$author')");
}
function uploadFiles()
{
    $coverName = $_FILES['cover']['name'];
    $coverTmp = $_FILES['cover']['tmp_name'];
    $bookName = $_FILES['book']['name'];
    $bookTmp = $_FILES['book']['tmp_name'];
    move_uploaded_file($coverTmp, '../assets/images/' . strval(time()) . '-' . $coverName);
    move_uploaded_file($bookTmp, '../assets/books/' . strval(time()) . '-id-' . $bookName);
    return array('cover' => strval(time()) . '-' . $coverName, 'book' => strval(time()) . '-id-' . $bookName);
}
function delBook($data)
{
    global $db;
    $isbn = htmlspecialchars($data["delISBN"]);
    $id = mysqli_query($db, "SELECT id from books WHERE isbn = '$isbn'");
    $users = mysqli_fetch_assoc($id);
    if (!ctype_digit($isbn) || strlen($isbn) != 13) {
        return '<span class="failed">ISBN must be a number only & with length of 13 digit.</span>';
    } elseif (!isbnCheck($isbn)) {
        return "<span class='failed'>ISBN is not found or has been deleted.</span>";
    } elseif (!isset($_POST["delete-confirm"])) {
        return "<span class='failed'>Delete confirmation has not been checked.</span>";
    } elseif ($_SESSION["idUser"] !== $users["id"]) {
        return "<span class='failed'>Can not be deleted. You are not the uploader.</span>";
    } else {
        $result = mysqli_query($db, "SELECT cover, book from books WHERE isbn = '$isbn'");
        $fileName = mysqli_fetch_assoc($result);
        if (file_exists('../assets/images/' . $fileName["cover"]) && file_exists('../assets/books/' . $fileName["book"])) {
            unlink('../assets/images/' . $fileName["cover"]);
            unlink('../assets/books/' . $fileName["book"]);
        } else {
            mysqli_query($db, "DELETE FROM books WHERE isbn = $isbn");
            return '<span class="success">Book is deleted.</span>';
        }
    }
}
function changePhoto()
{
    if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
        $mimeTypePhoto = mime_content_type($_FILES['photo']['tmp_name']);
        $fileTypesPhoto = ['image/png', 'image/jpg', 'image/jpeg'];
        if (!in_array($mimeTypePhoto, $fileTypesPhoto)) {
            return '<span class="failed">Not a supported file types.</span>';
        } elseif ($_FILES['photo']['size'] > 4200000) {
            return '<span class="failed">Image size is too big.</span>';
        } else {
            uploadPhoto();
            return '<span class="success">Photo is changed.</span>';
        }
    } else {
        return '<span class="failed">Please choose a file to upload.</span>';
    }
}
function uploadPhoto()
{
    global $db;
    $id = $_SESSION["idUser"];
    $result = mysqli_query($db, "SELECT picture from users WHERE id = '$id'");
    $photo = mysqli_fetch_assoc($result);
    if (file_exists('../assets/images/' . $photo["picture"]) && !photoCheck($id)) {
        unlink('../assets/images/' . $photo["picture"]);
        $fileName = uploadPhotoFiles();
        mysqli_query($db, "UPDATE users SET picture='$fileName' WHERE id = '$id'");
    } else {
        $fileName = uploadPhotoFiles();
        mysqli_query($db, "UPDATE users SET picture='$fileName' WHERE id = '$id'");
    }
}
function uploadPhotoFiles()
{
    $photoName = $_FILES['photo']['name'];
    $photoTmp = $_FILES['photo']['tmp_name'];
    move_uploaded_file($photoTmp, '../assets/images/' . strval(time()) . '-' . $photoName);
    return strval(time()) . '-' . $photoName;
}
function delPhoto()
{
    global $db;
    $id = $_SESSION["idUser"];
    $result = mysqli_query($db, "SELECT picture from users WHERE id = '$id'");
    $fileName = mysqli_fetch_assoc($result);
    if (photoCheck($id)) {
        return '<span class="failed">The current photo is default.</span>';
    } elseif (file_exists('../assets/images/' . $fileName["picture"])) {
        unlink('../assets/images/' . $fileName["picture"]);
        mysqli_query($db, "UPDATE users SET picture='default.png' WHERE id = '$id'");
        return '<span class="success">Photo is removed.</span>';
    } else {
        mysqli_query($db, "UPDATE users SET picture='default.png' WHERE id = '$id'");
        return '<span class="success">Photo is removed.</span>';
    }
}
function changeName($data)
{
    global $db;
    $id = $_SESSION["idUser"];
    $st = htmlspecialchars($data["first-name"]);
    $nd = htmlspecialchars($data["last-name"]);
    $result = mysqli_query($db, "SELECT first_name, last_name from users WHERE id = '$id'");
    $usersName = mysqli_fetch_assoc($result);
    if (!preg_match("/^(?!.*['-]{2})[a-zA-Z][a-zA-Z'\s-]{1,85}$/", $st) || !preg_match("/^(?!.*['-]{2})[a-zA-Z][a-zA-Z'\s-]{1,85}$/", $nd)) {
        return '<span class="failed">Please enter the appropriate Name & contains letter only.</span>';
    } elseif ($st === $usersName["first_name"] && $nd === $usersName["last_name"]) {
        return '<span class="failed">Name not changed.</span>';
    } else {
        mysqli_query($db, "UPDATE users SET first_name = '$st' WHERE id = '$id'");
        mysqli_query($db, "UPDATE users SET last_name = '$nd' WHERE id = '$id'");
        return '<span class="success">Name is changed.</span>';
    }
}
function changeEmail($data)
{
    global $db;
    $id = $_SESSION["idUser"];
    $new_email = htmlspecialchars($data["new_email"]);
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        return '<span class="failed">Please enter a valid Email format.</span>';
    } elseif (emailCheck($new_email)) {
        return '<span class="failed">Email address is already registered. Please use another one.</span>';
    } else {
        mysqli_query($db, "UPDATE users SET email = '$new_email' WHERE id = '$id'");
        return '<span class="success">Email is changed.</span>';
    }
}
function changePass($data)
{
    global $db;
    $id = $_SESSION["idUser"];
    $new_pass = htmlspecialchars($data["new-password"]);
    $old_pass = htmlspecialchars($data["old-password"]);
    $result = mysqli_query($db, "SELECT password FROM users WHERE id = '$id'");
    $pass = mysqli_fetch_assoc($result);
    if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $new_pass)) {
        return '<span class="failed">Password must be at least, 8 characters long, one uppercase, <br>one lowercase, one digit, and one special character.</span>';
    } elseif ($new_pass === $old_pass) {
        return "<span class='failed'>Please use a new password.</span>";
    } elseif (password_verify($old_pass, $pass["password"])) {
        $password = password_hash($new_pass, PASSWORD_DEFAULT);
        mysqli_query($db, "UPDATE users SET password = '$password' WHERE id = '$id'");
        return '<span class="success">Password is changed.</span>';
    } else {
        return '<span class="failed">The old password you entered is incorrect.</span>';
    }
}
function timeAgo($time)
{
    $periods = ["second", "minute", "hour", "day", "week", "month", "year", "decade"];
    $lengths = [60, 60, 24, 7, 4.35, 12, 10];
    $difference = time() - $time;
    for ($j = 0; $j < count($lengths) - 1 && $difference >= $lengths[$j]; $j++) {
        $difference /= $lengths[$j];
    }
    $difference = round($difference);
    $period = $periods[$j] . ($difference != 1 ? "s" : "");
    return "$difference $period ago";
}