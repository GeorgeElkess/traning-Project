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
if (!isset($_GET["Id"])) {
    echo "<script>
            location.replace('index.php');
        </script>";
    exit;
}
$User = ProductCategoryManger::GetById(intval(Encryption::Decrypt($_GET["Id"])));
?>
<!--  contact -->
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Update Product Category <?php echo $User->getId() ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="updateuser.php">
                    <input type="hidden" name="Id" value='<?php echo $User->getId()?>'>
                    <div class="row">
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Name" type="text" name="Name" value="<?php echo $User->getName(); ?>">
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
