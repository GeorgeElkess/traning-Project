<?php
include_once "../header.php";
include_once "../includes.php";
if (session_id() == '') {
    session_start();
}
if (isset($_SESSION["UserId"])) {
    $User = UserManger::GetById($_SESSION["UserId"]);
    if ($User == false) {
?>
        <script>
            location.replace("Logout.php");
        </script>
    <?php
        exit;
    }
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
}
?>
<!--  contact -->
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Forget Password</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="changepassword.php">
                    <div class="row">
                        <div class="col-md-12">
                            <input class="contactus" placeholder="UserName" type="text" name="UserName">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Email" type="email" name="Email">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="New Password" type="password" name="Password">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Confirm Password" type="password" name="ConPassword">
                        </div>
                        <div class="col-md-12">
                            <button class="send_btn">Set new Password</button>
                        </div>
                        <div class="col-md-12" style="text-align: center;">
                            <h3>
                                <a href="index.php" style="color: white;">return to login</a>
                            </h3>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end contact -->
<?php
include_once "../footer.php";
