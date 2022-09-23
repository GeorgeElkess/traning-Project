<?php
include_once "../../includes.php";
extract($_POST);
$User = new Product();
$Flag = false;
if (isset($CategoryId)) $User->getCategoryId($CategoryId);
if (isset($Name)) $User->setName($Name);
if (isset($Price)) $User->setPrice($Price);
if (isset($ImagePath)) $User->setImagePath($ImagePath);
if (ProductManger::Update(intval($Id), $User)) {
    $Flag = true;
} else {
    $ProductId = 0;
    $AllData = ProductManger::GetAll();
    foreach ($AllData as $Data) {
        $ProductId = $Data->getId();
    }
    $AllData = ProductCategoryOptionManger::GetAll(new ProductCategoryOption(null, $CategoryId));
    foreach ($AllData as $Data) {
        $Option = OptionsManger::GetById($Data->getOptionId());
        $OptionName = $Option->getName();
        if (isset($_POST[$OptionName])) {
            $Flag = true;
            $OptionValue = OptionValuesManger::GetAll(new OptionValues(null, $Data->getId(), $ProductId))[0];
            OptionValuesManger::Update($OptionValue->getId(), new OptionValues(null, $Data->getId(), $ProductId, $_POST[$OptionName]));
        }
    }
}
if($Flag){
    ?>
        <script>
            location.replace("index.php")
        </script>
    <?php
} else {
    include_once "../header.php";
    ?>
    <div style="text-align: center; margin: 100px auto;">
        <h1 style="color:red;">Invalid Values</h1>
    </div>
<?php
    include_once "../footer.php";
}
?>