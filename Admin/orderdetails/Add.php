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
?>
<!--  contact -->
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Add OrderDetail</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="adduser.php">
                    <div class="row">
                        <div class="col-md-12 ">
                            <select class="contactus" name="OrderId" id="OrderId" aria-placeholder="Order">
                                <option value="0" style="background-color: #4843a3;">Non</option>
                                <?php
                                $AllData = OrdersManger::GetAll();
                                foreach ($AllData as $Data) {
                                    echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getId() . "</option>";
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
                                    echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getName() . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Current Price" type="number" step=".1" name="CurrentPrice" Id="CurrentPrice">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Number" type="Number" name="Number">
                        </div>
                        <div class="col-md-12">
                            <button class="send_btn">Add</button>
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
