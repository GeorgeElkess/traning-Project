<?php
include_once "../../includes.php";
function getName(ProductCategoryOption $Data)
{
    $Name = "";
    if ($Data->getCategoryId() == null) return false;
    $Category = ProductCategoryManger::GetById($Data->getCategoryId());
    if ($Category == false) return false;
    $Name = $Category->getName();
    if ($Data->getOptionId() == null) return false;
    $Option = OptionsManger::GetById($Data->getOptionId());
    if ($Option == false) return false;
    $Name .= " " . $Option->getName();
    return $Name;
}
extract($_GET);
$AllData = OptionValuesManger::GetAll(new OptionValues($Id,$PCOId,$ProductId,$Values));
if($AllData!=false){
    foreach ($AllData as $Data) {
        echo "<tr>";
        echo "<td>" . $Data->getId() . "</td>";
        $Type = ProductCategoryOptionManger::GetById($Data->getPCOId());
        echo "<td>" . "<a href='../productcategoryoptions/index.php?Id=" . Encryption::Encrypt($Type->getId()) . "'>" . getName($Type) . "</a>" . "</td>";
        $Type = ProductManger::GetById($Data->getProductId());
        echo "<td>" . "<a href='../product/index.php?Id=" . Encryption::Encrypt($Type->getId()) . "'>" . $Type->getName() . "</a>" . "</td>";
        echo "<td>" . $Data->getValues() . "</td>";
        echo "<td>" . $Data->getCreatedAt() . "</td>";
        echo "<td>" . $Data->getUpdatedAt() . "</td>";
        echo "<td>" . "<a href=update.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Update</a>" . "</td>";
        echo "<td>" . "<a href=delete.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Delete</a>" . "</td>";
        echo "</tr>";
    }
}