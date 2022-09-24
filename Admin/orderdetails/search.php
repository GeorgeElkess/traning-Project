<?php
include_once "../../includes.php";
extract($_GET);
$AllData = OrderDetailsManger::GetAll(new OrderDetails($Id,$OrderId,$ProductId,$CurrentPrice,$Number));
if($AllData!=false){
    foreach ($AllData as $Data) {
        echo "<tr>";
        echo "<td>" . $Data->getId() . "</td>";
        echo "<td>" . "<a href='../orders/index.php?Id=" . Encryption::Encrypt($Data->getOrderId()) . "'>" . $Data->getOrderId() . "</a>" . "</td>";
        $Type = ProductManger::GetById($Data->getProductId());
        echo "<td>" . "<a href='../product/index.php?Id=" . Encryption::Encrypt($Type->getId()) . "'>" . $Type->getName() . "</a>" . "</td>";
        echo "<td>" . $Data->getCurrentPrice() . "</td>";
        echo "<td>" . $Data->getNumber() . "</td>";
        echo "<td>" . $Data->getCreatedAt() . "</td>";
        echo "<td>" . $Data->getUpdatedAt() . "</td>";
        echo "<td>" . "<a href=update.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Update</a>" . "</td>";
        echo "<td>" . "<a href=delete.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Delete</a>" . "</td>";
        echo "</tr>";
    }
}