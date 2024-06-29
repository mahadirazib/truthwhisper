<?php
require_once '../config.php';

if (!isset($_GET['id'])) {
    echo "Invalid URL.";
    exit;
}

$userId = $_GET['id'];
$usersFile = '../users/users.json';
$users = json_decode(file_get_contents($usersFile), true);

if (!isset($users[$userId])) {
    echo "Invalid URL.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = $_POST['comment'];
    $commentsFile = "../users/comments/$userId.json";
    $comments = file_exists($commentsFile) ? json_decode(file_get_contents($commentsFile), true) : [];

    $comments[] = $comment;
    file_put_contents($commentsFile, json_encode($comments));

    setFlashMessage('success', 'Thank you for your comment.');
    header("Location: comment.php?id=$userId");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comment on User</title>
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
    <h1>Comment on User</h1>
    <?php displayFlashMessage(); ?>
    <form method="POST">
        Comment: <textarea name="comment" required></textarea><br>
        <input type="submit" value="Submit Comment">
    </form>
</body>
</html>

<!-- <?php

?> -->
