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
include_once "../../models/usertype.php";
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
                                        <select class="contactus" name="TypeId" id="TypeId" aria-placeholder="Type" onmouseup="Search()">
                                            <option value="0" style="background-color: #4843a3;">All</option>
                                            <?php
                                            $AllData = UserTypeManger::GetAll();
                                            foreach ($AllData as $Data) {
                                                echo "<option value=" . $Data->getId() . " style='background-color: #4843a3;'>" . $Data->getName() . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus" placeholder="UserName" type="text" name="UserName" id="UserName" onkeyup="Search()">
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

                    string = "Id=" + document.getElementById("Id").value + "&UserName=" + document.getElementById("UserName").value + "&Email=" + document.getElementById("Email").value + "&Phone=" + document.getElementById("Phone").value;
                    // Hoe to get the value of select element in javascript?
                    i = document.getElementById("TypeId").selectedIndex;
                    string += "&TypeId=" + document.getElementById("TypeId").options[i].value;
                    console.log(string);
                    xmlObj.open("GET", "search.php?" + string, true);
                    xmlObj.send();
                }
            </script>
        </td>
        <td width=65%>
            <h2>
                <a href="Add.php"> Add User</a>
            </h2>
            <center>
                <h1>
                    Users
                </h1>
            </center>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Type</th>
                            <th>UserName</th>
                            <th>Email</th>
                            <th>Date of birth</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody Id="Table Body">
                        <?php
                        $AllData = UserManger::GetAll();
                        if ($AllData != false) {
                            foreach ($AllData as $Data) {
                                echo "<tr>";
                                echo "<td>" . $Data->getId() . "</td>";
                                $Type = UserTypeManger::GetById($Data->getTypeId());
                                echo "<td>" . $Type->getName() . "</td>";
                                echo "<td>" . $Data->getUserName() . "</td>";
                                echo "<td>" . $Data->getEmail() . "</td>";
                                echo "<td>" . $Data->getDateOfBirth() . "</td>";
                                echo "<td>" . $Data->getPhone() . "</td>";
                                echo "<td>" . $Data->getAddress() . "</td>";
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
