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
include_once "../../models/orders.php";
include_once "../../models/user.php";
$Id = 0;
if (isset($_GET["Id"])) $Id = intval(Encryption::Decrypt($_GET["Id"]));
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
                                        <select class="contactus" name="UserId" id="UserId" aria-placeholder="User" onmouseup="Search()">
                                            <option value="0" style="background-color: #4843a3;">All</option>
                                            <?php
                                            $AllData = UserManger::GetAll();
                                            foreach ($AllData as $Data) {
                                                echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getUserName() . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus" placeholder="Date" type="Date" name="Date" id="Date" onkeyup="Search()">
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus" placeholder="Email" type="Email" name="Email" id="Email" onkeyup="Search()">
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus" placeholder="Phone" type="text" name="Phone" id="Phone" onkeyup="Search()">
                                    </div>
                                </div>
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

                    string = "Id=" + document.getElementById("Id").value + "&Date=" + document.getElementById("Date").value;
                    i = document.getElementById("UserId").selectedIndex;
                    string += "&UserId=" + document.getElementById("UserId").options[i].value;
                    console.log(string);
                    xmlObj.open("GET", "search.php?" + string, true);
                    xmlObj.send();
                }
            </script>
        </td>
        <td width=65%>
            <h2>
                <a href="Add.php"> Add Order</a>
            </h2>
            <center>
                <h1>
                    Orders
                </h1>
            </center>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Details</th>
                            <th>Print</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody Id="Table Body">
                        <?php
                        $AllData = OrdersManger::GetAll();
                        if ($AllData != false) {
                            foreach ($AllData as $Data) {
                                echo "<tr>";
                                echo "<td>" . $Data->getId() . "</td>";
                                $Type = UserManger::GetById($Data->getUserId());
                                echo "<td>" . "<a href='../user/index.php?Id=" . Encryption::Encrypt($Type->getId()) . "'>" . $Type->getUserName() . "</a>" . "</td>";
                                echo "<td>" . $Data->getDate() . "</td>";
                                echo "<td>" . $Data->getCreatedAt() . "</td>";
                                echo "<td>" . $Data->getUpdatedAt() . "</td>";
                                echo "<td>" . "<a href='../orderdetails/index.php?OrderId=" . Encryption::Encrypt($Data->getId()) . "'>Details</a>" . "</td>";
                                echo "<td>" . "<a href/='printorder.php?Id=" . Encryption::Encrypt($Data->getId()) . "'>Details</a>" . "</td>";
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
