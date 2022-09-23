<?php
include_once "../../includes.php";
//How to extract variables from _POST?
extract($_POST);
$User = new User();
if(isset($TypeId)) $User->setTypeId($TypeId);
if(isset($UserName)) $User->setUserName($UserName);
if(isset($Email)) $User->setEmail($Email);
if(isset($DateOfBirth)) $User->setDateOfBirth($DateOfBirth);
if(isset($Phone)) $User->setPhone($Phone);
if(isset($Address)) $User->setAddress($Address);
if (UserManger::Update(intval($Id),$User)) {
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