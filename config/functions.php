<?php
$db = mysqli_connect("localhost", "root", "", "aksara_diskret");
function rowData($var)
{
    $rows = [];
    while ($row = mysqli_fetch_assoc($var)) {
        $rows[] = $row;
    }
    return $rows[0];
}


function CheckingEmail($email)
{
    global $db;
    // mengecek apakah email sudah terdaftar atau belum
    $result = mysqli_query($db, "SELECT email FROM users");
    $result_user = mysqli_query($db, "SELECT email FROM admin");
    $email_in_User = rowData($result);
    $email_in_Admin = rowData($result_user);
    if (in_array($email, $email_in_User) || in_array($email, $email_in_Admin)) {
        return true;
    }
    return false;
}

function CheckingBook($isbn)
{
    global $db;

    $result = mysqli_query($db, "SELECT isbn FROM books WHERE isbn = '$isbn'");
    $isAdd = rowData($result);

    if (!$isAdd) {
        return false;
    } else {
        return true;
    }
}

function addUser($data)
{

    global $db;
    $first_name = htmlspecialchars($data["first_name"]);
    $last_name = htmlspecialchars($data["last_name"]);
    $email = htmlspecialchars($data["email"]);
    $password = htmlspecialchars($data["password"]);


    //mengecek apakah $password kurang dari dari 8 karakter
    if (strlen("$password") < 8) {
        return '<span class="failed">Password must be at least 8 characters long.</span>';
    }
    // enskirpsi passowrd
    $hashpassword =  password_hash($password, PASSWORD_DEFAULT);
    $queryInsert = "INSERT INTO users VALUES ('', '$first_name','$last_name','$email','$hashpassword')";
    if (CheckingEmail($email)) {
        return '<span class="failed">Email address is already registered. Please use another email.</span>';
    }
    mysqli_query($db, $queryInsert);
    if (mysqli_affected_rows($db) > 0) {
        return '<span class="success">Registration successful! Welcome aboard.</span>';
    }
}

function addBook($data)
{
    global $db;

    $isbn = htmlspecialchars($data["isbn"]);
    $title = htmlspecialchars($data["title"]);
    $author = htmlspecialchars($data["author"]);

    if (strlen($isbn) != 13) {
        return '<span class="failed">ISBN must be 13 digits.</span>';
    } elseif (CheckingBook($isbn)) {
        return '<span class="failed">Book is already uploaded using this ISBN.</span>';
    } else {
        $fileName = upload();
        $cover = $fileName['cover'];
        $book = $fileName['book'];
        mysqli_query($db, "INSERT INTO books VALUES ('$cover','$book','$isbn','$title','$author')");
        return '<span class="success">Book is uploaded.</span>';
    }
}

function upload()
{
    $fileNameCover = $_FILES['cover']['name'];
    $tmpFileCover = $_FILES['cover']['tmp_name'];
    $fileNameBook = $_FILES['book']['name'];
    $tmpFileBook = $_FILES['book']['tmp_name'];

    move_uploaded_file($tmpFileCover, '../assets/image/' . strval(time()) . '-' . $fileNameCover);
    move_uploaded_file($tmpFileBook, '../assets/books/' . strval(time()) . '-' . $fileNameBook);

    return array('cover' => strval(time()) . '-' . $fileNameCover, 'book' => strval(time()) . '-' . $fileNameBook);
}

function delBook($data)
{
    global $db;

    $isbn = htmlspecialchars($data["delISBN"]);

    if (strlen($isbn) != 13) {
        return '<span class="failed">ISBN must be 13 digits.</span>';
    } else {
        $result = mysqli_query($db, "SELECT cover, book from books WHERE isbn = '$isbn'");
        $fileName = mysqli_fetch_assoc($result);

        if (file_exists('../assets/image/' . $fileName["cover"]) || file_exists('../assets/books/' . $fileName["book"])) {
            unlink('../assets/image/' . $fileName["cover"]);
            unlink('../assets/books/' . $fileName["book"]);
            mysqli_query($db, "DELETE FROM books WHERE isbn = $isbn");
            return '<span class="success">Book is deleted.</span>';
        } else {
            return '<span class="failed">ISBN is not found or has been deleted.</span>';
        }
    }
}

function Validation_signin($email, $pass)
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
        $row_users = rowData($result_users);
        if (password_verify($pass, $row_users["password"])) {
            $_SESSION["signinUser"] = true;
        } else {
            return true;
        }
        if (isset($_POST['remember-me'])) {
            setcookie('signin', $row_users["id"], time() + 60, '/');
            setcookie('secret', hash('sha512', $row_users["email"]), time() + 60, '/');
        }
        // The username will be taken from here when the new user logs in for the first time
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
    } else {
        $id = $_COOKIE["signin"];
        $data = mysqli_query($db, "SELECT email FROM admin WHERE id='$id'");
        $email_admin = mysqli_fetch_assoc($data);
        $email = $email_admin["email"];
        $table = (hash_equals($_COOKIE["secret"], hash("sha512", $email))) ? "admin" : "users";
    }

    if (CheckingEmail($new_email)) {
        return '<span class="failed">Email address is already registered. Please use another email.</span>';
    }

    mysqli_query($db, "UPDATE $table SET email='$new_email' WHERE id = '$id'");

    if (mysqli_affected_rows($db) > 0) {
        return '<span class="success">Email Changed</span>';
    }
}


function ChangePass($data)
{
    global $db;
    $new_pass = $data["new-password"];
    $old_pass = $data["old-password"];


    if ($new_pass === $old_pass) return "<span class='failed'>Enter new password!</span>";

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
        return '<span class="success">Password changed.</span>';
    }
    return '<span class="failed">The password you entered is incorrect.</span>';
}


function FeaturePrivilege()
{
    global $db;
    if (isset($_COOKIE["signin"])) {
        $id = $_COOKIE["signin"];
        $email = $_COOKIE["secret"];
        $data = mysqli_query($db, "SELECT email FROM admin WHERE id='$id'");
        if (isset($data)) {
            $email_admin = mysqli_fetch_assoc($data);
            if (isset($email_admin)) {

                if (hash_equals($email, hash('sha512', $email_admin['email']))) {
                    return true;
                }
            }
        }
    }
    return false;
}
