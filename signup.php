<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (createUser($username, $password)) {
        header("Location: index.php?signup=success");
        exit();
    } else {
        echo "Error creating user.";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Todolist App - Sign Up</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="index.php">Login</a></p>
    </div>
</body>
</html>
