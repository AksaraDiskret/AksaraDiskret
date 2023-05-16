<?php
$db = mysqli_connect("localhost", "root", "", "aksara_diskret");

function query($que)
{
    global $db;
    $result = mysqli_query($db, $que);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
