<?php
// Zahájení session
session_start();

// Zničení session
session_destroy();

// Přesměrování na login.php
header('Location: ../PHP/login.php');
exit();
?>
