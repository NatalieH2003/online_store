<?php
if(!function_exists("sanitizeInput")) {
    function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    function redirect($url) {
        header("Location: $url");
        exit;
    }

    function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            redirect('login.php');
        }
    }
}
?>
