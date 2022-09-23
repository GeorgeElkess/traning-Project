<?php
include_once "../../includes.php";
//How to extract variables from _POST?
extract($_POST);
$User = new OrderDetails();
if(isset($OrderId)) $User->setOrderId($OrderId);
if(isset($ProductId)) $User->setProductId($ProductId);
if(isset($CurrentPrice)) $User->setCurrentPrice($CurrentPrice);
if(isset($Number)) $User->setNumber($Number);
if (OrderDetailsManger::Update(intval($Id),$User)) {
?>
    <script>
        location.replace("index.php")
    </script>
<?php
    exit;
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