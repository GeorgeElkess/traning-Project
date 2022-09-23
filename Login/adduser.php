<?php
if (session_id() == '') {
    session_start();
}
include_once "../includes.php";
extract($_POST);
if ($ConPassword != $Password) {
    include_once "../header.php";
?>
    <div style="text-align: center; margin: 100px auto;">
        <h1 style="color:red;">Password Not match the confirm password</h1>
    </div>
<?php
    include_once "../footer.php";
    exit;
}
$User = new User(null, 2, $UserName, sha1($Password), $Email, $DateOfBirth, $Phone, $Address);
if (UserManger::Add($User)) {
    $LastId = 0;
    $AllData = UserManger::GetAll();
    foreach ($AllData as $Data) {
        $LastId = $Data->getId();
    }
    $_SESSION["UserId"] = $LastId;
?>
    <script>
        location.replace("../Client/");
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