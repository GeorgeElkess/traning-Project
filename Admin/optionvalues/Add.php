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
                        document.getElementById("PCOId").onchange = kk;
                        window.onload = kk;
                        function kk() {
                            This = document.getElementById("PCOId");
                            PCOId = This.options[This.selectedIndex].value;
                            check = [];
                            v = [];
                            <?php
                            $i = 0;
                            $AllData = ProductCategoryOptionManger::GetAll();
                            foreach ($AllData as $Data) {
                                $Option = OptionsManger::GetById($Data->getOptionId());
                                $Type = $Option->getType();
                                echo "check[$i]={PCOId: " . $Data->getId() . ", Type:'" . $Type . "', Category: " . $Data->getCategoryId() . "};";
                                $i++;
                            }
                            $i = 0;
                            $AllData = ProductManger::GetAll();
                            foreach ($AllData as $Data) {
                                echo "v[$i]={ProductId:" . $Data->getId() . ", ProductName:'" . $Data->getName() . "', Category: " . $Data->getCategoryId() . "};";
                                $i++;
                            }
                            ?>
                            for (let i = 0; i < check.length; i++) {
                                const element = check[i];
                                if (element.PCOId == PCOId) {
                                    document.getElementById("value").type = element.Type;
                                    select = document.getElementById("ProductId");
                                    select.innerHTML = "";
                                    child = document.createElement("option");
                                    child.value = 0;
                                    child.style = "background-color: #4843a3;";
                                    child.innerHTML = "Non";
                                    select.appendChild(child);
                                    for (let j = 0; j < v.length; j++) {
                                        const x = v[j];
                                        if (x.Category == element.Category) {
                                            child = document.createElement("option");
                                            child.value = x.ProductId;
                                            child.style = "background-color: #4843a3;";
                                            child.innerHTML = x.ProductName;
                                            select.appendChild(child);
                                        }
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
