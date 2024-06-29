<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username already exists
    $usersFile = '../users/users.json';
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    // Directly check if username exists
    if (isset($users[$username])) {
        setFlashMessage('danger', 'Username already exists. Please choose a different username.');
        header('Location: register.php');
        exit;
    }

    // Add new user with username as identifier
    $users[$username] = [
        'username' => $username,
        'password' => $password,
        'unique_url' => $_ENV['DOMAIN'] . "/unique_url.php?username=" . urlencode($username)
    ];

    // Save users to file
    file_put_contents($usersFile, json_encode($users));


    // Set success message
    setFlashMessage('success', 'User registered successfully.');

    // Redirect to login.php
    header('Location: login.php');
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
    </style>
</head>
<body>
    <h1>Register</h1>
    <?php displayFlashMessage(); ?>
    <form method="POST">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
    <a href="index.php">Back</a>
</body>
</html>
