<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "aksaradiskret");
function rowData($object_data)
{
    $rows = [];
    while ($row = mysqli_fetch_assoc($object_data)) {
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
    $email_in_db = rowData($result);
    if (in_array($email, $email_in_db)) {
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
    $password2 = htmlspecialchars($data["config_password"]);

    // mengecek konfigurasi password
    if ($password !== $password2) {
        return "<p style='color:red'>Password and confirmation do not match. Please try again.</p>";
    }
    // enskirpsi passowrd
    $hashpassword =  password_hash($password, PASSWORD_DEFAULT);
}
//     if (CheckingEmail($email)) {
//         return "<p style='color:red'>Email already registered. Choose another or log in.</p>";
//     }


//     $query = "INSERT INTO users VALUES ('','$first_name','$last_name','$email','$hashpassword')";
//     mysqli_query($db, $query);
//     $id = mysqli_query($db, "SELECT id FROM users WHERE email = '$email'");
//     $data_id = rowData($id)[0];
//     $_SESSION["id"] = $data_id;

//     if (mysqli_affected_rows($db) > 0) {
//         return "<p style='color:green'>Registration successful! Welcome aboard.</p>";
//     }
// }

// function ChangeEmail($data)
// {
//     global $db;
//     $new_email = htmlspecialchars($data["new_email"]);
//     $id = $_SESSION["id"];

//     if (CheckingEmail($new_email)) {
//         return "<p style='color:red'>Email already registered. Choose another or log in.</p>";
//     }

//     $hasil = mysqli_query($db, "UPDATE users SET email=$new_email WHERE id = '$id'");

//     if (mysqli_affected_rows($db) > 0) {
//         return "<p style='color:green'>Email Changed</p>";
//     }
// }

// function ChangePass($data)
// {
//     global $db;
//     global $id;
// }
