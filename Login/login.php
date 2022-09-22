<?php
if (session_id() == '') {
    session_start();
}
include_once "../includes.php";
extract($_POST);
$AllData = UserManger::GetAll(new User(null, null, $UserName));
if ($AllData!=false && sha1($Password) == $AllData[0]->getPassword()) {
    $User = $AllData[0];
    $_SESSION["UserId"] = $User->getId();
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
        <h1 style="color:red;">Invalid Login</h1>
    </div>
<?php
    include_once "../footer.php";
}
?>