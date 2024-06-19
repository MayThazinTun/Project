<?php 
setcookie("admin","", time() - 7000000,'/');

header("location:./index.php");

?>