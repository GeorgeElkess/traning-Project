<?php
if (session_id() == '') {
    session_start();
}
include_once "../includes.php";

if(isset($_GET["product_id"])&&isset($_GET["count"]))
{
   
    // here will open the sesstion and cheak if the client sign or not
      
    if(isset($_SESSION["UserId"]))
    {
     Add_to_card::Add_product($_SESSION["UserId"], $_GET["product_id"],$_GET["count"]);
     header('Location:index.php?card=1');
    }
    else
    {
        echo "you must log-in frist !!!!!";
    }
}
?>







