<?php
include_once "../../includes.php";
extract($_GET);
$AllData = ProductManger::GetAll(new Product(@$Id,@$TypeId,@$UserName,null,@$Email,null,@$Phone));
if($AllData!=false){
    foreach ($AllData as $Data) {
        echo "<tr>";
        echo "<td>" . $Data->getId() . "</td>";
        $Type = ProductCategoryManger::GetById($Data->getCategoryId());
        echo "<td>" . "<a href='../productcategory/index.php?Id=" . Encryption::Encrypt($Type->getId()) . "'>" . $Type->getName() . "</a>" . "</td>";
        echo "<td>" . $Data->getName() . "</td>";
        echo "<td>" . $Data->getPrice() . "</td>";
        echo "<td>" . $Data->getCreatedAt() . "</td>";
        echo "<td>" . $Data->getUpdatedAt() . "</td>";
        echo "<td>" . "<a href=details.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Details</a>" . "</td>";
        echo "<td>" . "<a href=update.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Update</a>" . "</td>";
        echo "<td>" . "<a href=delete.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Delete</a>" . "</td>";
        echo "</tr>";
    }
}