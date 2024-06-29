<?php
require_once '../config.php';

if (!isset($_GET['username'])) {
    echo "Invalid URL.";
    exit;
}

$userId = $_GET['username'];
$usersFile = '../users/users.json';
$users = json_decode(file_get_contents($usersFile), true);

if (!isset($users[$userId])) {
    echo "Invalid URL.";
    exit;
}

header("Location: comment.php?id=$userId");
exit;

