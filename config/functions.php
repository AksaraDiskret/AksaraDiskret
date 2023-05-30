<?php
$db = mysqli_connect("localhost", "root", "", "aksara_diskret");

function rowData($var)
{
    $rows = [];
    while ($row = mysqli_fetch_assoc($var)) {
        $rows[] = $row;
    }
    return $rows;
}
function rowData2($var)
{
    $rows = [];
    while ($row = mysqli_fetch_assoc($var)) {
        foreach ($row as $r) {
            $rows[] = $r;
        }
    }
    return $rows;
}

function checkCookie()
{
    global $db;
    $data_users = mysqli_query($db, "SELECT email FROM users");
    $data_admin = mysqli_query($db, "SELECT email FROM admin");

    if (isset($_COOKIE["secret"]) && isset($_COOKIE["signin"])) {
        $data1 = rowData2($data_users);
        foreach ($data1 as $data) {
            if (hash_equals($_COOKIE["secret"], hash('sha512', $data))) {
                $email_user = $data;
                $id_user = mysqli_query($db, "SELECT id FROM users WHERE email = '$email_user'");
                $_SESSION["idUser"] = mysqli_fetch_assoc($id_user)["id"];
                $_SESSION["signinUser"] = true;
            }
        }
        $data2 = rowData2($data_admin);
        foreach ($data2 as $data) {
            if (hash_equals($_COOKIE["secret"], hash('sha512', $data))) {
                $email_admin = $data;
                $id_admin = mysqli_query($db, "SELECT id FROM admin WHERE email = '$email_admin'");
                $_SESSION["idAdmin"] = mysqli_fetch_assoc($id_admin)["id"];
                $_SESSION["signin"] = true;
            }
        }
    }
}

function CheckingEmail($email)
{
    global $db;

    $result = mysqli_query($db, "SELECT email FROM users");
    $result_user = mysqli_query($db, "SELECT email FROM admin");
    $email_in_User = rowData2($result);
    $email_in_Admin = rowData2($result_user);
    if (in_array($email, $email_in_User) || in_array($email, $email_in_Admin)) {
        return true;
    }
    return false;
}

function bookCheck($isbn)
{
    global $db;

    $result = mysqli_query($db, "SELECT isbn FROM books WHERE isbn = '$isbn'");
    $isAdd = rowData($result);
    return (!$isAdd) ? false : true;
}

function addUser($data)
{

    global $db;
    $first_name = htmlspecialchars($data["first_name"]);
    $last_name = htmlspecialchars($data["last_name"]);
    $email = htmlspecialchars($data["email"]);
    $password = htmlspecialchars($data["password"]);

    if (strlen("$password") < 8) {
        return '<span class="failed">Password must be at least 8 characters long.</span>';
    }

    $hashpassword =  password_hash($password, PASSWORD_DEFAULT);
    $queryInsert = "INSERT INTO users VALUES ('', '$first_name','$last_name','$email','$hashpassword')";
    if (CheckingEmail($email)) {
        return '<span class="failed">Email address is already registered. Please use another email.</span>';
    }
    mysqli_query($db, $queryInsert);
    if (mysqli_affected_rows($db) > 0) {
        return '<span class="success">Registration is successful. Welcome aboard.</span>';
    }
}

function bookAction($data)
{
    $isbn = htmlspecialchars($data["isbn"]);
    $title = htmlspecialchars($data["title"]);
    $author = htmlspecialchars($data["author"]);

    if (!ctype_digit($isbn) || strlen($isbn) != 13) {
        return '<span class="failed">ISBN must be a number only &  with length of 13 digit.</span>';
    } elseif (!preg_match('/^[\w ]+$/', $title)) {
        return '<span class="failed">Please enter the appropriate Title format, only letters & numbers.</span>';
    } elseif (!preg_match("/^(?!.*['-]{2})[a-zA-Z][a-zA-Z'\s-]{1,20}$/", $author)) {
        return '<span class="failed">Please enter the appropriate Name format, only letters.</span>';
    } elseif (!isset($_POST["book-action"])) {
        return '<span class="failed">Please choose a action.</span>';
    } elseif (isset($data["confirm-action"])) {
        if ($_POST["book-action"] == "edit") {
            editBook($data);
            return '<span class="success">Book is edited.</span>';
        } elseif ($_POST["book-action"] == "upload") {
            if (bookCheck($isbn)) {
                return '<span class="failed">Book is already uploaded using this ISBN.</span>';
            } elseif ($_FILES['cover']['error'] || $_FILES['book']['error'] === 4) {
                return '<span class="failed">Please choose a files to upload.</span>';
            } elseif (is_uploaded_file($_FILES['cover']['tmp_name']) || is_uploaded_file($_FILES['book']['tmp_name'])) {
                $mimeTypeCover = mime_content_type($_FILES['cover']['tmp_name']);
                $mimeTypeBook = mime_content_type($_FILES['book']['tmp_name']);
                $fileTypesCover = ['image/png', 'image/jpg', 'image/jpeg'];
                $fileTypesBook = ['application/pdf'];

                if (!in_array($mimeTypeCover, $fileTypesCover) || !in_array($mimeTypeBook, $fileTypesBook)) {
                    return '<span class="failed">Not a supported files type.</span>';
                } elseif ($_FILES['cover']['size'] > 24000000 || $_FILES['book']['size'] > 720000000) {
                    return '<span class="failed">File sizes is too big.</span>';
                } else {
                    uploadBook($data);
                    return '<span class="success">Book is uploaded.</span>';
                }
            }
        } else {
            return '<span class="failed">None of the options match.</span>';
        }
    } else {
        return '<span class="failed">Agreement confirmation has not been checked.</span>';
    }
}

function uploadBook($data)
{
    global $db;

    $isbn = htmlspecialchars($data["isbn"]);
    $title = htmlspecialchars($data["title"]);
    $author = htmlspecialchars($data["author"]);

    $fileName = uploadFiles();
    $cover = $fileName['cover'];
    $book = $fileName['book'];
    mysqli_query($db, "INSERT INTO books VALUES ('$cover','$book','$isbn','$title','$author')");
}

function uploadFiles()
{
    $coverName = $_FILES['cover']['name'];
    $coverTmp = $_FILES['cover']['tmp_name'];
    $bookName = $_FILES['book']['name'];
    $bookTmp = $_FILES['book']['tmp_name'];

    move_uploaded_file($coverTmp, '../assets/image/' . strval(time()) . '-' . $coverName);
    move_uploaded_file($bookTmp, '../assets/books/' . strval(time()) . '-' . $bookName);

    return array('cover' => strval(time()) . '-' . $coverName, 'book' => strval(time()) . '-' . $bookName);
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

function delBook($data)
{
    global $db;

    $isbn = htmlspecialchars($data["delISBN"]);

    if (!ctype_digit($isbn) || strlen($isbn) != 13) {
        return '<span class="failed">ISBN must be a number only &  with length of 13 digit.</span>';
    } elseif (!bookCheck($isbn)) {
        return "<span class='failed'>ISBN is not found or has been deleted.</span>";
    } elseif (!isset($_POST["delete-confirm"])) {
        return "<span class='failed'>Delete confirmation has not been checked.</span>";
    } else {
        $result = mysqli_query($db, "SELECT cover, book from books WHERE isbn = '$isbn'");
        $fileName = mysqli_fetch_assoc($result);
        if (file_exists('../assets/image/' . $fileName["cover"]) && file_exists('../assets/books/' . $fileName["book"])) {
            unlink('../assets/image/' . $fileName["cover"]);
            unlink('../assets/books/' . $fileName["book"]);
        } else {
            mysqli_query($db, "DELETE FROM books WHERE isbn = $isbn");
            return '<span class="success">Book is deleted.</span>';
        }
    }
}

function validationSignin($email, $pass)
{
    global $db;
    $result = mysqli_query($db, "SELECT * FROM admin WHERE email = '$email'");
    $result_users = mysqli_query($db, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($result) >= 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($pass, $row["password"])) {
            $_SESSION["signin"] = true;
        } else {
            return true;
        }
        if (isset($_POST['remember-me'])) {
            setcookie('signin', $row['id'], time() + 60, '/');
            setcookie('secret', hash('sha512', $row['email']), time() + 60, '/');
        }
        $_SESSION["idAdmin"] = $row["id"];
        header("Location: ../collection");
        exit;
    }
    if (mysqli_num_rows($result_users) >= 1) {
        $row_users = rowData($result_users)[0];
        if (password_verify($pass, $row_users["password"])) {
            $_SESSION["signinUser"] = true;
        } else {
            return true;
        }
        if (isset($_POST['remember-me'])) {
            setcookie('signin', $row_users["id"], time() + 60, '/');
            setcookie('secret', hash('sha512', $row_users["email"]), time() + 60, '/');
        }

        $first_name = $row_users['first_name'];
        $last_name = $row_users['last_name'];

        $_SESSION["USERNAME"] = "$first_name $last_name";
        $_SESSION["idUser"] = $row_users['id'];
        header("Location: ../collection");
        exit;
    }

    return true;
}

function ChangeEmail($data)
{
    $new_email = htmlspecialchars($data["new_email"]);
    global $db;

    if (isset($_SESSION["idUser"]) || isset($_SESSION["idAdmin"])) {
        $table = (isset($_SESSION["idAdmin"])) ? "admin" : "users";
        $id = ($table === "users") ? $_SESSION["idUser"] : $_SESSION["idAdmin"];
    }

    if (CheckingEmail($new_email)) {
        return '<span class="failed">Email address is already registered. Please use another email.</span>';
    }

    mysqli_query($db, "UPDATE $table SET email='$new_email' WHERE id = '$id'");

    if (mysqli_affected_rows($db) > 0) {
        return '<span class="success">Email is changed.</span>';
    }
}

function ChangePass($data)
{
    global $db;
    $new_pass = $data["new-password"];
    $old_pass = $data["old-password"];


    if ($new_pass === $old_pass) return "<span class='failed'>Please enter a new password.</span>";

    if (strlen($new_pass) < 8) {
        return '<span class="failed">Password must be at least 8 characters long.</span>';
    }

    if (isset($_SESSION["idUser"]) || isset($_SESSION["idAdmin"])) {
        $table = (isset($_SESSION["idAdmin"])) ? "admin" : "users";
        $id = ($table === "users") ? $_SESSION["idUser"] : $_SESSION["idAdmin"];
    } else {
        $id = $_COOKIE["signin"];
        $data_email = mysqli_query($db, "SELECT email FROM admin WHERE id='$id'");
        $email_admin = mysqli_fetch_assoc($data_email);
        $email = $email_admin["email"];
        $table = (hash_equals($_COOKIE["secret"], hash("sha512", "$email"))) ? "admin" : "users";
    }

    $query = mysqli_query($db, "SELECT password FROM $table WHERE id = '$id'");
    $passwoor_in_db = mysqli_fetch_assoc($query);
    if (password_verify($old_pass, $passwoor_in_db["password"])) {
        $hashpassword = password_hash($new_pass, PASSWORD_DEFAULT);
        mysqli_query($db, "UPDATE $table SET password = '$hashpassword' WHERE id = '$id'");
        return '<span class="success">Password is changed.</span>';
    }
    return '<span class="failed">The old password you entered is incorrect.</span>';
}

function FeaturePrivilege()
{
    return (isset($_SESSION["signin"])) ? true : false;
}