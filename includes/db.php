<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'todolist_app';

try {
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

session_start();

function createUser($username, $password) {
    global $conn;

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function loginUser($username, $password) {
    global $conn;

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['id'];
    } else {
        return false;
    }
}