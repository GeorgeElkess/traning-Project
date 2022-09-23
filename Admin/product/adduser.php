<?php
include_once "../../includes.php";
//How to extract variables from _POST?
extract($_POST);
$User = new Product(null, $CategoryId, $Name,$Price,$_FILES["ImagePath"]["name"]);
if(ProductManger::Add($User)) {
    $ProductId = 0;
    $AllData = ProductManger::GetAll();
    foreach ($AllData as $Data) {
        $ProductId = $Data->getId();
    }
    $AllData = ProductCategoryOptionManger::GetAll(new ProductCategoryOption(null,$CategoryId));
    if($AllData!=false){
        foreach ($AllData as $Data) {
            $Option = OptionsManger::GetById($Data->getOptionId());
            $OptionName = $Option->getName();
            if(isset($_POST[$OptionName])) {
                OptionValuesManger::Add(new OptionValues(null,$Data->getId(),$ProductId,$_POST[$OptionName]));
            }
        }
    }
    ?> 
        <script>location.replace("index.php")</script>
    <?php 
    exit;
} else {
    include_once "../header.php";   
    ?>
    <div style="text-align: center; margin: 100px auto;">
        <h1  style="color:red;">Invalid Values</h1>
    </div>
    <?php
    include_once "../footer.php";
}  
?>