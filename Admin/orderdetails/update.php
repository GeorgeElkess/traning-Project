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
$User = OrderDetailsManger::GetById(intval(Encryption::Decrypt($_GET["Id"])));
?>
<!--  contact -->
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Update OrderDetail <?php echo $User->getId() ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="updateuser.php">
                    <input type="hidden" name="Id" value='<?php echo $User->getId() ?>'>
                    <div class="row">
                        <div class="col-md-12 ">
                            <select class="contactus" name="OrderId" id="OrderId" aria-placeholder="Order">
                                <option value="0" style="background-color: #4843a3;">Non</option>
                                <?php
                                $AllData = OrdersManger::GetAll();
                                foreach ($AllData as $Data) {
                                    if ($Data->getId() == $User->getOrderId()) {
                                        echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;' selected>" . $Data->getId() . "</option>";
                                    } else {
                                        echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getId() . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <select class="contactus" name="ProductId" id="ProductId" aria-placeholder="Product">
                                <option value="0" style="background-color: #4843a3;">Non</option>
                                <?php
                                $AllData = ProductManger::GetAll();
                                foreach ($AllData as $Data) {
                                    if ($Data->getId() == $User->getProductId()) {
                                        echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;' selected>" . $Data->getName() . "</option>";
                                    } else {
                                        echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getName() . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Current Price" type="number" id="CurrentPrice" step=".1" name="CurrentPrice" value="<?php echo $User->getCurrentPrice(); ?>">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Number" type="number" name="Number" value="<?php echo $User->getNumber(); ?>">
                        </div>
                        <div class="col-md-12">
                            <button class="send_btn">Update</button>
                        </div>
                    </div>
                    <script>
                        document.getElementById("ProductId").onchange = function() {
                            x = document.getElementById("ProductId");
                            value = x.options[x.selectedIndex].value;
                            check = [];
                            <?php
                            $AllData = ProductManger::GetAll();
                            for ($i = 0; $i < count($AllData); $i++) {
                                $Data = $AllData[$i];
                                echo "check[$i]={Id:" . $Data->getId() . ", Price:" . $Data->getPrice() . "};";
                            }
                            ?>
                            for (let i = 0; i < check.length; i++) {
                                const element = check[i];
                                if (value == element.Id) {
                                    document.getElementById("CurrentPrice").value = element.Price;
                                }
                            }
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end contact -->
<?php
include_once "../footer.php";
