<?php
include_once "../header.php";
include_once "../includes.php";
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end contact -->
<?php
include_once "../footer.php";
