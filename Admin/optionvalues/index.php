<?php
if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION["UserId"])) {
    echo "<script>
            location.replace('/GitHub/traning-Project/Login/index.php');
        </script>";
    exit;
}
include_once "../header.php";
include_once "../../models/Encryption.php";
include_once "../../models/options.php";
include_once "../../models/optionvalues.php";
include_once "../../models/product.php";
$Id = 0;
if (isset($_GET["Id"])) $Id = intval(Encryption::Decrypt($_GET["Id"]));
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

<table width=100%>
    <tr width=100%>
        <td width=35%>
            <div class="contact">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="titlepage">
                                <h2>Filter</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <form id="request" class="main_form" method="POST" action="adduser.php">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input class="contactus" placeholder="Id" type="number" name="Id" id="Id" onkeyup="Search()" value="<?php echo $Id ?>">
                                    </div>
                                    <div class="col-md-12 ">
                                        <select class="contactus" name="PCOId" id="PCOId" aria-placeholder="Category Option" onmouseup="Search()">
                                            <option value="0" style="background-color: #4843a3;">All</option>
                                            <?php
                                            $AllData = ProductCategoryOptionManger::GetAll();
                                            foreach ($AllData as $Data) {
                                                echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . getName($Data) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <select class="contactus" name="ProductId" id="ProductId" aria-placeholder="ProductId" onmouseup="Search()">
                                            <option value="0" style="background-color: #4843a3;">All</option>
                                            <?php
                                            $AllData = ProductManger::GetAll();
                                            foreach ($AllData as $Data) {
                                                echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getName() . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus" placeholder="Value" type="text" name="Values" id="Values" onkeyup="Search()">
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
                                                document.getElementById("Values").type = element.Type;
                                            }
                                        }
                                    }
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                <?php if (isset($_GET["Id"])) { ?>
                    window.onload = function() {
                        Search()
                    };
                <?php } ?>

                function Search() {
                    xmlObj = new XMLHttpRequest();
                    xmlObj.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("Table Body").innerHTML = this.responseText;
                        }
                    };

                    string = "Id=" + document.getElementById("Id").value + "&Values=" + document.getElementById("Values").value;
                    i = document.getElementById("PCOId").selectedIndex;
                    string += "&PCOId=" + document.getElementById("PCOId").options[i].value;
                    i = document.getElementById("ProductId").selectedIndex;
                    string += "&ProductId=" + document.getElementById("ProductId").options[i].value;
                    console.log(string);
                    xmlObj.open("GET", "search.php?" + string, true);
                    xmlObj.send();
                }
            </script>
        </td>
        <td width=65%>
            <h2>
                <a href="Add.php"> Add Extra Value</a>
            </h2>
            <center>
                <h1>
                    Extra Values
                </h1>
            </center>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Category Option</th>
                            <th>Product</th>
                            <th>Value</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody Id="Table Body">
                        <?php
                        $AllData = OptionValuesManger::GetAll();
                        if ($AllData != false) {
                            foreach ($AllData as $Data) {
                                echo "<tr>";
                                echo "<td>" . $Data->getId() . "</td>";
                                $Type = ProductCategoryOptionManger::GetById($Data->getPCOId());
                                echo "<td>" . "<a href='../productcategoryoptions/index.php?Id=" . Encryption::Encrypt($Type->getId()) . "'>" . getName($Type) . "</a>" . "</td>";
                                $Type = ProductManger::GetById($Data->getProductId());
                                echo "<td>" . "<a href='../product/index.php?Id=" . Encryption::Encrypt($Type->getId()) . "'>" . $Type->getName() . "</a>" . "</td>";
                                echo "<td>" . $Data->getValues() . "</td>";
                                echo "<td>" . $Data->getCreatedAt() . "</td>";
                                echo "<td>" . $Data->getUpdatedAt() . "</td>";
                                echo "<td>" . "<a href=update.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Update</a>" . "</td>";
                                echo "<td>" . "<a href=delete.php?Id=" . Encryption::Encrypt($Data->getId()) . ">Delete</a>" . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    <tbody>
                </table>
            </div>

        </td>
    </tr>
</table>

<?php
include_once "../footer.php";
