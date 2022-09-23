<?php
if (session_id() == '') {
    session_start();
}
include_once "../header.php";
include_once "../../includes.php";
if (!isset($_SESSION["UserId"])) {
    echo "<script>
            location.replace('/GitHub/traning-Project/Login/index.php');
        </script>";
    exit;
}
?>
<!--  contact -->
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Add Order</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="adduser.php">
                    <div class="row">
                        <div class="col-md-12 ">
                            <select class="contactus" name="UserId" id="UserId" aria-placeholder="User">
                                <option value="0" style="background-color: #4843a3;">Non</option>
                                <?php
                                $AllData = UserManger::GetAll();
                                foreach ($AllData as $Data) {
                                    echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getUserName() . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Date" type="Date" name="Date">
                        </div>
                        <div class="col-md-12">
                            <button class="send_btn">Add</button>
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
