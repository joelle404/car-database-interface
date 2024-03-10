<?php
session_start();


// Destroy the session
session_destroy();


// Redirect to the login page or public page
header("Location: login.html");
?>
