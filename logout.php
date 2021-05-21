<?php 
session_start();
$_SESSION["user_id"] = "";
session_destroy();
if(isset($_COOKIE["username"]))
{
    setcookie("username", "", time()-3600);
}

header("Location: index.php");