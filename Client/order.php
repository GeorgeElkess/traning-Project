<?php
if (session_id() == '') {
  session_start();
}
include_once "../includes.php";
?>
<table>
<tr>
<th> order</th>
<th> Amount</th>
<th> price</th>
</tr>
     
    <?php
     $obj=new connection();
     $obj2=new connection();
     $obj3=new connection();
     $obj4=new connection();


     $obj->return_special_colom("card",$_SESSION["UserId"],"product_id","Id");
     
     $obj2->return_special_colom("card",$_SESSION["UserId"],"count","Id");
      $obj4->return_special_colom("product",$_SESSION["UserId"],"price","Id");
     for($i=0;$i<count($obj->arry_object);$i++)
     {
      $obj3=new connection();
      $obj3->return_special_colom("product",$obj->arry_object[$i],"Name","Id");
      echo "<tr>"."<td>".$obj3->arry_object[$i]."</td>"."<td>".$obj2->arry_object[$i]."<td>".$obj4->arry_object[$i]."</td>"."</tr>"."</td>";
     }
    
      echo'<p>'.'you will pay :'.Encryption::Decrypt($_REQUEST["total_payed"]).'$'.'</p>';
      echo "<p>your order :</p>"

    ?>
    </table>
       <!-- 
             make the order 
        -->
      
        <?php
        $obj5=new connection();
        for($i=0;$i<count($obj->arry_object);$i++)
        {
           $date = date('Y-m-d');
           $obj2=new connection();
           $lastid=$obj->getlastitem("orders","Id");
          //here using sessin and get user id
          $aa=$_SESSION["UserId"];
           $data="('$lastid','$aa','$date','$date','$date')";
           $obj2->insert("orders",$data);

           
        //  <!-- make orderdetalis -->
               
        $obj4=new connection();
         $obj4->return_special_colom("product",$obj->arry_object[$i],"price","Id");

            $date = date('Y-m-d');
            $obj3=new connection();
            
            $obj5->return_special_colom("card",1,"count","Id");
            $lastid2=$obj->getlastitem("orderdetails","Id");
           //here using sessin and get user id

            $object=$obj->arry_object[$i];
            $object4=$obj4->arry_object[0];
            $object2=$obj5->arry_object[$i];
            $data="('$lastid2','$lastid','$object','$object4',$object2,'$date','$date')";
             $obj3->insert("orderdetails",$data);
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

th, td {
  text-align: left;
  padding: 10px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
  background-color: #04AA6D;
  color: white;
}
#buy
{
    display: flex;
  
}
.button-37 {
  background-color: #13aa52;
  border: 1px solid #13aa52;
  border-radius: 4px;
  box-shadow: rgba(0, 0, 0, .1) 0 2px 4px 0;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  font-family: "Akzidenz Grotesk BQ Medium", -apple-system, BlinkMacSystemFont, sans-serif;
  font-size: 16px;
  font-weight: 400;
  outline: none;
  outline: 0;
  padding: 10px 25px;
  text-align: center;
  transform: translateY(0);
  transition: transform 150ms, box-shadow 150ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-37:hover {
  box-shadow: rgba(0, 0, 0, .15) 0 3px 9px 0;
  transform: translateY(-2px);
}

@media (min-width: 768px) {
  .button-37 {
    padding: 5px 20px;
  }
}
.button-38{
  background-color: #FF0000;
  border: 1px solid #FF0000;
  border-radius: 4px;
  box-shadow: rgba(0, 0, 0, .1) 0 2px 4px 0;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  font-family: "Akzidenz Grotesk BQ Medium", -apple-system, BlinkMacSystemFont, sans-serif;
  font-size: 16px;
  font-weight: 400;
  outline: none;
  outline: 0;
  padding: 10px 25px;
  text-align: center;
  transform: translateY(0);
  transition: transform 150ms, box-shadow 150ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-38:hover {
  box-shadow: rgba(0, 0, 0, .15) 0 3px 9px 0;
  transform: translateY(-2px);
}

@media (min-width: 768px) {
  .button-38 {
    padding: 5px 20px;
  }
}
p
{
  margin-left: 20%;
  text-transform: uppercase;
  font: optional;
  color: #ff0000;
}

</style>
<!-- -------------------------- -->
</body>
</html> 



