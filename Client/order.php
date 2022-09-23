<?php
if (session_id() == '') {
  session_start();
}
include_once "../includes.php";
include_once "../header.php";
$User = UserManger::GetById($_SESSION["UserId"]);
echo "<p>Client: ".$User->getUserName()."</p>";
echo "<p>Date: ". date('Y-m-d')."</p>";
?>
<table>
  <tr>
    <th> order</th>
    <th> Amount</th>
    <th> price</th>
  </tr>

  <?php
  $obj = new connection();
  $obj2 = new connection();
  $obj3 = new connection();

  $obj->return_special_colom("card", $_SESSION["UserId"], "product_id", "Id");
  $obj2->return_special_colom("card", $_SESSION["UserId"], "count", "Id");
  for ($i = 0; $i < count($obj->arry_object); $i++) {
    $obj4 = new connection();
    $obj3 = new connection();
    $obj3->return_special_colom("product", $obj->arry_object[$i], "Name", "Id");
    $obj4->return_special_colom("product", $obj->arry_object[$i], "price", "Id");
    echo "<tr>" . "<td>" . $obj3->arry_object[0] . "</td>" . "<td>" . $obj2->arry_object[$i] . "<td>" . $obj4->arry_object[0] . "</td>" . "</tr>" . "</td>";
  }

  ?>
</table>

<!-- 
             make the order 
        -->

<?php
echo '<p>' . 'you will pay :' . Encryption::Decrypt($_REQUEST["total_payed"]) . '$' . '</p>';
$obj5 = new connection();
OrdersManger::Add(new Orders(null,$_SESSION["UserId"], date('Y-m-d')));
$OrderId = 0;
$AllData = OrdersManger::GetAll();
foreach ($AllData as $Data) {
  $OrderId = $Data->getId();
}
for ($i = 0; $i < count($obj->arry_object); $i++) {
  //  <!-- make orderdetalis -->

  $obj4 = new connection();
  $obj4->return_special_colom("product", $obj->arry_object[$i], "price", "Id");

  $date = date('Y-m-d');
  $obj3 = new connection();

  $obj5->return_special_colom("card", $_SESSION["UserId"], "count", "Id");
  $lastid2 = $obj->getlastitem("orderdetails", "Id");
  //here using sessin and get user id

  $object = $obj->arry_object[$i];
  $object4 = $obj4->arry_object[0];
  $object2 = $obj5->arry_object[$i];
  $data = "('$lastid2','$lastid','$object','$object4',$object2,'$date','$date')";
  $obj3->insert("orderdetails", $data);
}
?>

<!-- the css for the add form -->
<style>
  table {
    border-collapse: collapse;
    width: 30%;
    border: 10px solid white;
    margin-left: 20%;
    margin-right: 30%;
    /* height: 60%; */
  }

  th,
  td {
    text-align: left;
    padding: 10px;
  }

  tr:nth-child(even) {
    background-color: #f2f2f2
  }

  th {
    background-color: #04AA6D;
    color: white;
  }

  p {
    margin-left: 20%;
    text-transform: uppercase;
    font: optional;
    color: #ff0000;
  }
</style>
<!-- -------------------------- -->
<?php
include_once "../footer.php";
