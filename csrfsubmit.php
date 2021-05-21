<?php 
if (isset($_POST['CSRFToken'])) {
    $csrftoken = $_POST['CSRFToken'];
}
if($csrftoken != "MYJRGQTmzM12WN1GEjD2OQOMlOEjDjM4wMwmmOYYYNwxENWAl2UMQVGZ4IYhTDGZ4YJMDZZwjiwhYWJNE==")
{
    $denyAccess = true;
}
    
else 
{
    if (isset($_POST['fname'])) {
    $fname = $_POST['fname'];
}

if (isset($_POST['lname'])) {
    $lname = $_POST['lname'];
}

$denyAccess = false;
}
    


?>
<html>
<body>
<a href="index.php">Go back </a>
<?php if(!$denyAccess){?>
    Welcome <?php echo $fname . ' ' . $lname;?> <br> <?php
}
else
{ ?>
    INTRUDER ALERT! WRONG CSRFTOKEN DETECTED
    <?php
}
?>

</body>
</html>