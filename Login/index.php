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
                    <h2>Login</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="Login.php">
                    <div class="row">
                        <div class="col-md-12">
                            <input class="contactus" placeholder="UserName" type="text" name="UserName">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Password" type="password" name="Password">
                        </div>
                        <div class="col-md-12">
                            <button class="send_btn">Login</button>
                        </div>
                        <div class="col-md-12" style="text-align: center;">
                            <h3>
                                <a href="forgetpassword.php" style="color: white;">Forget Password</a>
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
