<?php
if (session_id() == '') {
    session_start();
}
include_once "../includes.php";
extract($_POST);
$AllData = UserManger::GetAll(new User(null, null, $UserName));
if ($AllData != false && $Email == $AllData[0]->getEmail()) {
    $User = $AllData[0];
    $_SESSION["UserId"] = $User->getId();
    if ($Password != $ConPassword) {
        include_once "../header.php";
?>
        <div style="text-align: center; margin: 100px auto;">
            <h1 style="color:red;">Password Not match the confirm password</h1>
        </div>
    <?php
        include_once "../footer.php";
        exit;
    }
    UserManger::Update($User->getId(),new User(null,null,null,sha1($Password)));
    if ($User->getTypeId() == 1) {
    ?>
        <script>
            location.replace("../Admin/user/");
        </script>
    <?php
    } else {
    ?>
        <script>
            location.replace("../Client/");
        </script>
    <?php
    }
    exit;
} else {
    include_once "../header.php";
    ?>
    <div style="text-align: center; margin: 100px auto;">
        <h1 style="color:red;">Invalid values</h1>
    </div>
<?php
    include_once "../footer.php";
}
?>