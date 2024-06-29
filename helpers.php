<?php
function setFlashMessage($type, $message) {
    $_SESSION['flash'][$type] = $message;
}

function displayFlashMessage() {
    if (isset($_SESSION['flash'])) {
        foreach ($_SESSION['flash'] as $type => $message) {
            if($type == "success"){
                echo "<div class='alert alert-$type text-sm font-semibold text-green-800'>$message</div>";
            }elseif($type == "success"){
                echo "<div class='alert alert-$type text-sm font-semibold text-red-800'>$message</div>";
            }else{
                echo "<div class='alert alert-$type text-sm font-semibold'>$message</div>";
            }
        }
        unset($_SESSION['flash']);
    }
}

