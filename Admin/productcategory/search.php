<?php
include_once "../../includes.php";
extract($_GET);
$AllData = ProductCategoryManger::GetAll(new ProductCategory($Id,$Name));
if($AllData!=false){
    foreach ($AllData as $Data) {
        echo "<tr>";
        echo "<td>" . $Data->getId() . "</td>";
        echo "<td>" . $Data->getName() . "</td>";
        echo "<td>" . $Data->getCreatedAt() . "</td>";
        echo "<td>" . $Data->getUpdatedAt() . "</td>";
        echo "<td>" . "<a href=update.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Update</a>" . "</td>";
        echo "<td>" . "<a href=delete.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Delete</a>" . "</td>";
        echo "</tr>";
    }
}