<?php
session_start();
session_unset();
session_destroy();
header("Location:http://localhost/dila/php/Login.php");
exit();
?>