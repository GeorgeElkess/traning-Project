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
}
$ProductId = $Id;
$AllData = ProductCategoryOptionManger::GetAll(new ProductCategoryOption(null, $CategoryId));
if($AllData!=false) {
    foreach ($AllData as $Data) {
        $Option = OptionsManger::GetById($Data->getOptionId());
        $OptionName = $Option->getName();
        $OptionName = str_replace(" ","_",$OptionName);
        if (isset($_POST[$OptionName])) {
            $Flag = true;
            $OptionValue = OptionValuesManger::GetAll(new OptionValues(null, $Data->getId(), $ProductId));
            if($OptionValue!=false) {
                $OptionValue = $OptionValue[0];
                OptionValuesManger::Update($OptionValue->getId(), new OptionValues(null, $Data->getId(), $ProductId, $_POST[$OptionName]));
            } else {
                OptionValuesManger::Add(new OptionValues(null,$Data->getId(),$ProductId, $_POST[$OptionName]));
            }
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