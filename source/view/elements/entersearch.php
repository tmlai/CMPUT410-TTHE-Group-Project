<?php
session_start();
$_SESSION['search'] = $_GET['searchField'];

echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=../search.php\">\n";
?>
