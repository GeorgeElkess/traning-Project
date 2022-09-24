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
$Id = "";
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
                                    <div class="col-md-12">
                                        <input class="contactus" placeholder="Name" type="text" name="Name" id="Name" onkeyup="Search()">
                                    </div>
                                    <div class="col-md-12">
                                        <select class="contactus" name="Type" id="Type" onmouseup="Search()">
                                            <option style='background-color: #4843a3;' value="">All</option>
                                            <option style='background-color: #4843a3;' value="number">Number</option>
                                            <option style='background-color: #4843a3;' value="Text">Text</option>
                                            <option style='background-color: #4843a3;' value="Date">Date</option>
                                            <option style='background-color: #4843a3;' value="Time">Time</option>
                                        </select>
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

                    string = "Id=" + document.getElementById("Id").value + "&Name=" + document.getElementById("Name").value;
                    i = document.getElementById("Type").selectedIndex;
                    string += "&Type=" + document.getElementById("Type").options[i].value;
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
                    Extra Value
                </h1>
            </center>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody Id="Table Body">
                        <?php
                        $AllData = OptionsManger::GetAll();
                        if ($AllData != false) {
                            foreach ($AllData as $Data) {
                                echo "<tr>";
                                echo "<td>" . $Data->getId() . "</td>";
                                echo "<td>" . $Data->getName() . "</td>";
                                echo "<td>" . $Data->getType() . "</td>";
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
