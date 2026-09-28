<?php
session_start();
session_unset();
session_destroy();

header("Location: login.php"); // Sesuaikan dengan nama file login Anda
exit();
?>