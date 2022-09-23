<?php
include_once "../../includes.php";
//How to extract variables from _POST?
extract($_POST);
$User = new Orders();
if(isset($UserId)) $User->setUserId($UserId);
if(isset($Date)) $User->setDate($Date);
if (OrdersManger::Update(intval($Id),$User)) {
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