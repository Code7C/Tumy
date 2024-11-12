<?php
session_start();
session_unset();
session_destroy();
header("Location: principal2.php");
exit();
?>
//lola