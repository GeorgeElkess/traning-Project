<?php
if (session_id() == '') {
    session_start();
}
include_once "../header.php";
include_once "../../includes.php";
if(!isset($_SESSION["UserId"])){
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
                    <h2>Add User</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="adduser.php">
                    <div class="row">
                        <div class="col-md-12 ">
                            <select class="contactus" name="TypeId" id="TypeId" aria-placeholder="Type">
                                <option value="0" style="background-color: #4843a3;">Non</option>
                                <?php
                                $AllData = UserTypeManger::GetAll();
                                foreach ($AllData as $Data) {
                                    echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getName() . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="UserName" type="text" name="UserName">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Email" type="Email" name="Email">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Password" type="password" name="Password">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Date of Birth" type="Date" name="DateOfBirth">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Phone" type="text" name="Phone">
                        </div>
                        <div class="col-md-12">
                            <textarea class="textarea" placeholder="Address" type="text" name="Address"></textarea>
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
