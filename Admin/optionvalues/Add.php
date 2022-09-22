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
function getName(ProductCategoryOption $Data)
{
    $Name = "";
    if ($Data->getCategoryId() == null) return false;
    $Category = ProductCategoryManger::GetById($Data->getCategoryId());
    if ($Category == false) return false;
    $Name = $Category->getName();
    if ($Data->getOptionId() == null) return false;
    $Option = OptionsManger::GetById($Data->getOptionId());
    if ($Option == false) return false;
    $Name .= " " . $Option->getName();
    return $Name;
}
?>
<!--  contact -->
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Add Extra Value</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="adduser.php">
                    <div class="row">
                        <div class="col-md-12 ">
                            <select class="contactus" name="PCOId" id="PCOId" aria-placeholder="PCOId">
                                <option value="0" style="background-color: #4843a3;">Non</option>
                                <?php
                                $AllData = ProductCategoryOptionManger::GetAll();
                                foreach ($AllData as $Data) {
                                    echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . getName($Data) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <select class="contactus" name="ProductId" id="ProductId" aria-placeholder="ProductId">
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
                            <input class="contactus" placeholder="Value" type="text" name="Values" Id="value">
                        </div>
                        <div class="col-md-12">
                            <button class="send_btn">Add</button>
                        </div>
                    </div>
                    <script>
                        document.getElementById("PCOId").onchange = function() {
                            This = document.getElementById("PCOId");
                            PCOId = This.options[This.selectedIndex].value;
                            check = [];
                            <?php
                            $i = 0;
                            $AllData = ProductCategoryOptionManger::GetAll();
                            foreach ($AllData as $Data) {
                                $Option = OptionsManger::GetById($Data->getOptionId());
                                $Type = $Option->getType();
                                echo "check[$i]={PCOId: " . $Data->getId() . ", Type:'" . $Type . "'};";
                                $i++;
                            }
                            ?>
                            for (let i = 0; i < check.length; i++) {
                                const element = check[i];
                                if (element.PCOId == PCOId) {
                                    document.getElementById("value").type = element.Type;
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
