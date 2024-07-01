<?php
function setFlashMessage($type, $message) {
    $_SESSION['flash'][$type] = $message;
}

function displayFlashMessage() {
    if (isset($_SESSION['flash'])) {
        foreach ($_SESSION['flash'] as $type => $message) {
            if($type == "success"){
                echo "<div class='alert alert-$type mt-6 text-sm font-semibold text-green-800'>$message</div>";
            }elseif($type == "danger"){
                echo "<div class='alert alert-$type mt-6 text-sm font-semibold text-red-800'>$message</div>";
            }else{
                echo "<div class='alert alert-$type mt-6 text-sm font-semibold'>$message</div>";
            }

            echo '<script> 
                setTimeout(() => {
                document.querySelectorAll(".alert").forEach(function (item) {
                    item.remove();
                })
                }, "3000");
                </script>';
        }
        unset($_SESSION['flash']);
    }
}

