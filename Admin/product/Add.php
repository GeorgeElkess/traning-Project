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
                    <h2>Add Product</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="adduser.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 ">
                            <select class="contactus" name="CategoryId" id="CategoryId" aria-placeholder="Category">
                                <option value="0" style="background-color: #4843a3;">Non</option>
                                <?php
                                $AllData = ProductCategoryManger::GetAll();
                                foreach ($AllData as $Data) {
                                    echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getName() . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Name" type="text" name="Name">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Price" type="number" step=".1" name="Price">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Image" type="file" name="ImagePath">
                        </div>
                        <div Id="Extra Data"></div>
                        <div class="col-md-12">
                            <button class="send_btn">Add</button>
                        </div>
                    </div>
                    <script>
                        document.getElementById("CategoryId").onchange = function() {
                            value = document.getElementById("CategoryId").value;
                            check = [];
                            <?php
                            $i = 0;
                            $AllData = ProductCategoryOptionManger::GetAll();
                            foreach ($AllData as $Data) {
                                $x = OptionsManger::GetById($Data->getOptionId());
                                echo "check[$i]={CategoryId:'" . $Data->getCategoryId() . "', Name:'" . $x->getName() . "', Type:'" . $x->getType() . "'};";
                                $i++;
                            }
                            ?>
                            x = document.getElementById("Extra Data");
                            x.innerHTML = "";
                            for (let i = 0; i < check.length; i++) {
                                const element = check[i];
                                if (element.CategoryId == value) {
                                    string = "<div class='col-md-12'>";
                                    string = "<input class='contactus' placeholder='"+element.Name+"' type='"+element.Type+"' name='"+element.Name+"'>";
                                    string += "</div>";
                                    x.innerHTML+=string;
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
