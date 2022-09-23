<?php
include_once "../header.php";
include_once "../../includes.php";
if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION["UserId"])) {
    echo "<script>
            location.replace('/GitHub/traning-Project/Login/index.php');
        </script>";
    exit;
}
if (!isset($_GET["Id"])) {
    echo "<script>
            location.replace('index.php');
        </script>";
    exit;
}
$Info = ProductManger::GetById(intval(Encryption::Decrypt($_GET["Id"])));
$ExtraValues = OptionValuesManger::GetAll(new OptionValues(null,null,$Info->getId()));
?>

<table class="ProductDetails">
    <tbody>
        <tr>
            <td class="ProductImageSection">
                <img src="<?php echo $Info->getImagePath() ?>" alt="<?php echo $Info->getName() ?>">
            </td>
            <td class="ProductDetailsSection">
                <h4>Category <?php echo (ProductCategoryManger::GetById($Info->getCategoryId()))->getName() ?></h4>
                <h2><?php echo $Info->getName() ?></h2>
                <hr>
                <div class="ProductPrice">
                    <sup>EGP</sup>
                    <h3><?php echo $Info->getPrice() ?></h3>
                </div>
                <hr>
                <div>
                    <?php 
                    if($ExtraValues!=false){
                        foreach ($ExtraValues as $Value) {
                            $PCO = ProductCategoryOptionManger::GetById($Value->getPCOId());
                            $Option = OptionsManger::GetById($PCO->getOptionId());
                            $Name = $Option->getName();
                            echo "<h4>".$Name.": ".$Value->getValues()."</h4>";
                        }
                    }
                    ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<?php
include_once "../footer.php";
?>