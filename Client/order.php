<?php
if (session_id() == '') {
  session_start();
}
if (!isset($_SESSION["UserId"])) {
  echo "<script>
            location.replace('/GitHub/traning-Project/Login/index.php');
        </script>";
  exit;
}
include_once "../includes.php";
include_once "../models/card.php";
$User = UserManger::GetById($_SESSION["UserId"]);
OrdersManger::Add(new Orders(null, $User->getId(), date("y-m-d")));
$OrderId = 0;
$AllData = OrdersManger::GetAll();
foreach ($AllData as $Data) {
  $OrderId = $Data->getId();
}
$AllData = CardManger::GetAll(new Card($User->getId()));
if ($AllData != false) {
  foreach ($AllData as $Data) {
    $Product = ProductManger::GetById($Data->getproduct_id());
    OrderDetailsManger::Add(new OrderDetails(null, $OrderId, $Product->getId(), $Product->getPrice(), $Data->getcount()));
  }
}
CardManger::Delete(new Card($User->getId()));
?>
<script>
  location.replace('/GitHub/traning-Project/Client/printorder.php?Id=<?php echo Encryption::Encrypt($OrderId)?>');
</script>