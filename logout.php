<?php
session_start();

// Delete all variables for session
$_SESSION = [];

// "Kill" session
session_destroy();

// Delete cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Rediract to ma=in page
header("Location: index.php");
exit();
?>
