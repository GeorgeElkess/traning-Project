<?php
include_once "../../includes.php";
extract($_GET);
$AllData = UserManger::GetAll(new User($Id,$TypeId,$UserName,null,$Email,null,$Phone));
if($AllData!=false){
    foreach ($AllData as $Data) {
        echo "<tr>";
        echo "<td>" . $Data->getId() . "</td>";
        $Type = UserTypeManger::GetById($Data->getTypeId());
        echo "<td>" . $Type->getName() . "</td>";
        echo "<td>" . $Data->getUserName() . "</td>";
        echo "<td>" . $Data->getEmail() . "</td>";
        echo "<td>" . $Data->getDateOfBirth() . "</td>";
        echo "<td>" . $Data->getPhone() . "</td>";
        echo "<td>" . $Data->getAddress() . "</td>";
        echo "<td>" . $Data->getCreatedAt() . "</td>";
        echo "<td>" . $Data->getUpdatedAt() . "</td>";
        echo "<td>" . "<a href=update.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Update</a>" . "</td>";
        echo "<td>" . "<a href=delete.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Delete</a>" . "</td>";
        echo "</tr>";
    }
}