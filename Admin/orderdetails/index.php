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
include_once "../../models/orderdetails.php";
include_once "../../models/orders.php";
include_once "../../models/product.php";
$Id = 0;
if (isset($_GET["Id"])) $Id = intval(Encryption::Decrypt($_GET["Id"]));
$OrderId = "";
if (isset($_GET["OrderId"])) $OrderId = intval(Encryption::Decrypt($_GET["OrderId"]));
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
                                        <select class="contactus" name="OrderId" id="OrderId" aria-placeholder="Order" onmouseup="Search()">
                                            <option value="0" style="background-color: #4843a3;">All</option>
                                            <?php
                                            $AllData = OrdersManger::GetAll();
                                            foreach ($AllData as $Data) {
                                                if ($OrderId != "" && $Data->getId() == $OrderId) echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;' selected>" . $Data->getId() . "</option>";
                                                else echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getId() . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <select class="contactus" name="ProductId" id="ProductId" aria-placeholder="Product" onmouseup="Search()">
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
                                        <input class="contactus" placeholder="Current Price" type="number" step=".1" name="CurrentPrice" id="CurrentPrice" onkeyup="Search()">
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus" placeholder="Number" type="number" name="Number" id="Number" onkeyup="Search()">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                <?php if (isset($_GET["Id"]) || $OrderId != "") { ?>
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

                    string = "Id=" + document.getElementById("Id").value + "&CurrentPrice=" + document.getElementById("CurrentPrice").value + "&Number=" + document.getElementById("Number").value;
                    // Hoe to get the value of select element in javascript?
                    i = document.getElementById("OrderId").selectedIndex;
                    string += "&OrderId=" + document.getElementById("OrderId").options[i].value;
                    i = document.getElementById("ProductId").selectedIndex;
                    string += "&ProductId=" + document.getElementById("ProductId").options[i].value;
                    console.log(string);
                    xmlObj.open("GET", "search.php?" + string, true);
                    xmlObj.send();
                }
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
        </td>
        <td width=65%>
            <h2>
                <a href="Add.php"> Add OrderDetail</a>
            </h2>
            <center>
                <h1>
                    OrderDetails
                </h1>
            </center>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>OrderId</th>
                            <th>Product</th>
                            <th>CurrentPrice</th>
                            <th>Number</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody Id="Table Body">
                        <?php
                        $AllData = OrderDetailsManger::GetAll();
                        if ($AllData != false) {
                            foreach ($AllData as $Data) {
                                echo "<tr>";
                                echo "<td>" . $Data->getId() . "</td>";
                                echo "<td>" . "<a href='../orders/index.php?Id=" . Encryption::Encrypt($Data->getId()) . "'>" . $Data->getId() . "</a>" . "</td>";
                                $Type = ProductManger::GetById($Data->getProductId());
                                echo "<td>" . "<a href='../product/index.php?Id=" . Encryption::Encrypt($Type->getId()) . "'>" . $Type->getName() . "</a>" . "</td>";
                                echo "<td>" . $Data->getCurrentPrice() . "</td>";
                                echo "<td>" . $Data->getNumber() . "</td>";
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
