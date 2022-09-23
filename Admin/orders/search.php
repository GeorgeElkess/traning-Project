<?php
include_once "../../includes.php";
extract($_GET);
$AllData = OrdersManger::GetAll(new Orders($Id,$UserId,$Date));
if($AllData!=false){
    foreach ($AllData as $Data) {
        echo "<tr>";
        echo "<td>" . $Data->getId() . "</td>";
        $Type = UserManger::GetById($Data->getUserId());
        echo "<td>" . "<a href='../user/index.php?Id=" . Encryption::Encrypt($Type->getId()) . "'>" . $Type->getUserName() . "</a>" . "</td>";
        echo "<td>" . $Data->getDate() . "</td>";
        echo "<td>" . $Data->getCreatedAt() . "</td>";
        echo "<td>" . $Data->getUpdatedAt() . "</td>";
        echo "<td>" . "<a href='../orderdetails/index.php?OrderId=" . Encryption::Encrypt($Data->getId()) . "'>Details</a>" . "</td>";
        echo "<td>" . "<a href=update.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Update</a>" . "</td>";
        echo "<td>" . "<a href=delete.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Delete</a>" . "</td>";
        echo "</tr>";
    }
}