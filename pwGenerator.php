<?php
session_start();
include("index.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $length = $_POST['lengthBox'];
    $amount = $_POST['amountBox'];
    $text = $_POST['alphabetBox'];
    if(empty($length))
    {
        echo "Please specify a length<br>"; 
    }
    if(empty($amount))
    {
        echo "Please enter an amount<br>";
    }
    if(empty($text))
    {
        echo "Please designate an alphabet<br>";
    }
    if(!empty($length) && !empty($amount) && !empty($text))    
    {
        echo "<div class = 'container bg-secondary rounded'><br>";
        echo ("<span class='text-light'>$amount Passwörter mit einer Länge von $length Zeichen wurden erstellt:</span><br>");
        for($i = 0; $i < $amount; $i++)      
        {
            echo"<br>";          
            $password = [];
            $textLength = strlen($text) - 1;          
            for($j = 0; $j < $length; $j++)
            {                
                $ranChar = rand(0, $textLength);
                $password[] = $text[$ranChar];            
            }            
            echo "<span class='font-weight-bold'>Password " . strval($i + 1) . ":</span> " . "<span class='text-light'>" . implode($password) . "</span>";
        }
        echo"</div>";
    }
}
?>
</body>
</html>
