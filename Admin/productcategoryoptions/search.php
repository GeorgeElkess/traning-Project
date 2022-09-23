<?php
include_once "../../includes.php";
extract($_GET);
$AllData = ProductCategoryOptionManger::GetAll(new ProductCategoryOption($Id,$CategoryId,$OptionId));
if($AllData!=false){
    foreach ($AllData as $Data) {
        echo "<tr>";
        echo "<td>" . $Data->getId() . "</td>";
        $Type = ProductCategoryManger::GetById($Data->getCategoryId());
        echo "<td>" . "<a href='../productcategory/index.php?Id=" . Encryption::Encrypt($Type->getId()) . "'>" . $Type->getName() . "</a>" . "</td>";
        $Type = OptionsManger::GetById($Data->getOptionId());
        echo "<td>" . "<a href='../options/index.php?Id=" . Encryption::Encrypt($Type->getId()) . "'>" . $Type->getName() . "</a>" . "</td>";
        echo "<td>" . $Data->getCreatedAt() . "</td>";
        echo "<td>" . $Data->getUpdatedAt() . "</td>";
        echo "<td>" . "<a href=update.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Update</a>" . "</td>";
        echo "<td>" . "<a href=delete.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Delete</a>" . "</td>";
        echo "</tr>";
    }
}