<?php
$db = mysqli_connect("localhost", "root", "", "aksara_diskret");
function rowData($que)
{
    $rows = [];
    while ($row = mysqli_fetch_assoc($que)) {
        foreach ($row as $r) {
            $rows[] = $r;
        }
    }
    return $rows;
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
        if (password_verify($pass, $row_users[4])) {
            $_SESSION["signinUser"] = true;
        } else {
            return true;
        }
        if (isset($_POST['remember-me'])) {
            setcookie('signin', $row_users[0], time() + 60, '/');
            setcookie('secret', hash('sha512', $row_users[3]), time() + 60, '/');
        }
        // The username will be taken from here when the new user logs in for the first time
        $_SESSION["USERNAME"] = "$row_users[1] $row_users[2]";
        $_SESSION["idUser"] = $row_users[0];
        header("Location: ../collection");
        exit;
    }

    return true;
}



function addNewEmailAfterChange($new_email, $id)
{
    global $db;
    if (CheckingEmail($new_email)) {
        return '<span class="failed">Email address is already registered. Please use another email.</span>';
    }

    mysqli_query($db, "UPDATE users SET email='$new_email' WHERE id = '$id'");

    if (mysqli_affected_rows($db) > 0) {
        return '<span class="success">Email Changed</span>';
    }
};

function ChangeEmail($data)
{
    $new_email = htmlspecialchars($data["new_email"]);
    if (isset($_SESSION["idUser"])) {
        $id_User = $_SESSION["idUser"];
    } else {
        $id_Admin = $_SESSION["idAdmin"];
    }

    if (isset($id_Admin)) {
        return addNewEmailAfterChange($new_email, $id_Admin);
    } else {
        return addNewEmailAfterChange($new_email, $id_User);
    }
}


function ChangePass($data)
{
    global $db;
    $id = $_SESSION["idUser"];
    $new_pass = $data["new-password"];
    $old_pass = $data["old-password"];

    if (strlen($new_pass) < 8) {

        return '<span class="failed">Password must be at least 8 characters long.</span>';
    }

    if (password_verify($new_pass, $old_pass)) {
        $hashpassword = password_hash($new_pass, PASSWORD_DEFAULT);
        mysqli_query($db, "UPDATE users SET password = '$hashpassword' WHERE id = '$id'");
        return '<span class="success">Password changed.</span>';
    }
    return '<span class="failed">The password you entered is incorrect.</span>';
}
