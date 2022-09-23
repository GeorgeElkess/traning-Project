<?php
include_once "../header.php";
include_once "../../includes.php";
if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION["UserId"])) {
    echo "<script>
            location.replace('/GitHub/traning-Project/Login/index.php');
        </script>";
    exit;
}
if (!isset($_GET["Id"])) {
    echo "<script>
            location.replace('index.php');
        </script>";
    exit;
}
$User = UserManger::GetById(intval(Encryption::Decrypt($_GET["Id"])));
?>
<!--  contact -->
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Update User <?php echo $User->getId() ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="updateuser.php">
                    <input type="hidden" name="Id" value='<?php echo $User->getId()?>'>
                    <div class="row">
                        <div class="col-md-12 ">
                            <select class="contactus" name="TypeId" id="TypeId" aria-placeholder="Type">
                                <option value="0" style="background-color: #4843a3;">Non</option>
                                <?php
                                $AllData = UserTypeManger::GetAll();
                                foreach ($AllData as $Data) {
                                    if ($Data->getId() == $User->getTypeId()) {
                                        echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;' selected>" . $Data->getName() . "</option>";
                                    } else {
                                        echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getName() . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="UserName" type="text" name="UserName" value="<?php echo $User->getUserName(); ?>">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Email" type="Email" name="Email" value="<?php echo $User->getEmail(); ?>">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Date of Birth" type="Date" name="DateOfBirth" value="<?php echo $User->getDateOfBirth(); ?>">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Phone" type="text" name="Phone" value="<?php echo $User->getPhone(); ?>">
                        </div>
                        <div class="col-md-12">
                            <textarea class="textarea" placeholder="Address" type="text" name="Address"><?php echo $User->getAddress(); ?></textarea>
                        </div>
                        <div class="col-md-12">
                            <button class="send_btn">Update</button>
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
