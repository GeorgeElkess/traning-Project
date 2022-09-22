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
$User = ProductCategoryOptionManger::GetById(intval(Encryption::Decrypt($_GET["Id"])));
?>
<!--  contact -->
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Update Category Option <?php echo $User->getId() ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="updateuser.php">
                    <input type="hidden" name="Id" value='<?php echo $User->getId() ?>'>
                    <div class="row">
                        <div class="col-md-12 ">
                            <select class="contactus" name="CategoryId" id="CategoryId" aria-placeholder="CategoryId">
                                <option value="0" style="background-color: #4843a3;">Non</option>
                                <?php
                                $AllData = ProductCategoryManger::GetAll();
                                foreach ($AllData as $Data) {
                                    if ($Data->getId() == $User->getCategoryId()) {
                                        echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;' selected>" . $Data->getName() . "</option>";
                                    } else {
                                        echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getName() . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <select class="contactus" name="OptionId" id="OptionId" aria-placeholder="OptionId">
                                <option value="0" style="background-color: #4843a3;">Non</option>
                                <?php
                                $AllData = OptionsManger::GetAll();
                                foreach ($AllData as $Data) {
                                    if ($Data->getId() == $User->getOptionId()) {
                                        echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;' selected>" . $Data->getName() . "</option>";
                                    } else {
                                        echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getName() . "</option>";
                                    }
                                }
                                ?>
                            </select>
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
