<?php
require_once '../config.php';
session_start();
session_destroy();
setFlashMessage('success', 'You have successfully logged out.');
header('Location: index.php');
exit;

