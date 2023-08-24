<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user_id = loginUser($username, $password);

    if ($user_id) {
        header("Location: dashboard.php?user_id=$user_id");
        exit();
    } else {
        echo "Invalid login credentials.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Todolist App - Login</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="index.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
</body>
</html>
