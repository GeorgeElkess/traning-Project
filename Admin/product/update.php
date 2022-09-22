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
$User = ProductManger::GetById(intval(Encryption::Decrypt($_GET["Id"])));
?>
<!--  contact -->
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Update Product <?php echo $User->getId() ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="updateuser.php" enctype="multipart/form-data">
                    <input type="hidden" name="Id" value='<?php echo $User->getId() ?>'>
                    <div class="row">
                        <div class="col-md-12 ">
                            <select class="contactus" name="CategoryId" id="CategoryId" aria-placeholder="Type">
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
                            <input class="contactus" placeholder="Name" type="text" name="Name" value="<?php echo $User->getName(); ?>">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Price" type="number" step=".1" name="Price" value="<?php echo $User->getPrice(); ?>">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="ImagePath" type="file" name="ImagePath" value="<?php echo $User->getImagePath(); ?>">
                        </div>
                        <div Id="Extra Data"></div>
                        <div class="col-md-12">
                            <button class="send_btn">Update</button>
                        </div>
                    </div>
                    <script>
                        document.getElementById("CategoryId").onchange = kk;
                        window.onload = kk;

                        function kk() {
                            value = document.getElementById("CategoryId").value;
                            check = [];
                            v = [];
                            <?php
                            $i = 0;
                            $AllData = ProductCategoryOptionManger::GetAll();
                            foreach ($AllData as $Data) {
                                $x = OptionsManger::GetById($Data->getOptionId());
                                echo "check[$i]={PCOId:" . $Data->getId() . ", CategoryId:'" . $Data->getCategoryId() . "', Name:'" . $x->getName() . "', Type:'" . $x->getType() . "'};";
                                $i++;
                            }
                            $AllData = OptionValuesManger::GetAll(new OptionValues(null, null, $User->getId()));
                            $i = 0;
                            foreach ($AllData as $Data) {
                                echo "v[$i]={PCOId: " . $Data->getPCOId() . ", Value:'" . $Data->getValues() . "'};";
                                $i++;
                            }
                            ?>
                            x = document.getElementById("Extra Data");
                            x.innerHTML = "";
                            for (let i = 0; i < check.length; i++) {
                                const element = check[i];
                                if (element.CategoryId == value) {
                                    flag = false;
                                    for (let j = 0; j < v.length; j++) {
                                        const c = v[j];
                                        if (c.PCOId == element.PCOId) {
                                            flag = true;
                                            string = "<div class='col-md-12'>";
                                            string = "<input class='contactus' placeholder='" + element.Name + "' type='" + element.Type + "' name='" + element.Name + "' value='" + c.Value + "'>";
                                            string += "</div>";
                                            x.innerHTML += string;
                                        }
                                    }
                                    if (!flag) {
                                        string = "<div class='col-md-12'>";
                                        string = "<input class='contactus' placeholder='" + element.Name + "' type='" + element.Type + "' name='" + element.Name + "'>";
                                        string += "</div>";
                                        x.innerHTML += string;
                                    }
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
