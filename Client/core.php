<?php
include_once "../includes.php";

if(isset($_GET["product_id"])&&isset($_GET["count"]))
{
   
    Add_to_card::Add_product( $_GET["product_id"],$_GET["count"]);
    
    header('Location:product.php?card=1');
}
?>







