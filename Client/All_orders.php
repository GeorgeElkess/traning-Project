<?php
if (session_id() == '') {
    session_start();
}
include_once "../includes.php";
$user_id=($_SESSION["UserId"]);
?>
<!-- here will filter the date -->
        <?php
        if(isset($_GET["date"]))
        {
            $obj=new connection();
            $obj->return_special_colom("orders",$_GET["date"],"Id","Date");
            if(count($obj->arry_object)==0)
            { 
             include_once "../header.php";
             echo "NO Order with id: ".$user_id;
             include_once "../footer.php";
            
             exit;
         
            }
            $obj2=new connection();
            $obj2->return_special_colom("user",$user_id,"UserName","Id");
            
         //    get the date of the orders
            $obj3=new connection();
            $obj3->return_special_colom("orders",$_GET["date"],"Date","Date");

            ?>
            filter by:
        <select id="selectBox" onchange="filter_product(value)">
        <optgroup label="products">
        <option value="" disabled selected>Select your date</option>
        <option value="all" >Select All date</option>
         <?php
              $obj4=new connection();
              $obj4->return_special_colom("orders",$user_id,"Date","UserId");
                for($i=0;$i<count($obj4->arry_object);$i++)
                {
           
                  echo '<option value='.$obj4->arry_object[$i].'>'.$obj4->arry_object[$i].'</option>';
                }
            
          
         ?>
          </optgroup>
        </select> 
          <table >
     <tr>
       <th>Order Id</th>
       <th> User</th>
       <th> Date</th>
       <th> Print</th>

     </tr>
            <?php
       for ($i = 0; $i<count($obj->arry_object); $i++) 
       {
      
        echo "<tr>"."<td>".$obj->arry_object[$i]."</td>"."<td>".$obj2->arry_object[0] . "<td>" . $obj3->arry_object[$i] . "</td>"."<td>" .'<a href="printorder.php?Id='. Encryption::Encrypt($obj->arry_object[$i]).'">Print</a>'. "</td>" . "</tr>" . "</td>";
       }

       ?>
       </table>
       <?php
       return;

        }
          ?>
        <!-- 000000000000000000000000000 -->
<?php

//    get the Id_order for this user
   $obj=new connection();
   $obj->return_special_colom("orders",$user_id,"Id","UserId");
   if(count($obj->arry_object)==0)
   { 
    include_once "../header.php";
    echo "NO Order with id: ".$user_id;
    include_once "../footer.php";
   
    exit;

   }
   //    get the user name;
   $obj2=new connection();
   $obj2->return_special_colom("user",$user_id,"UserName","Id");
   
//    get the date of the orders
   $obj3=new connection();
   $obj3->return_special_colom("orders",$user_id,"Date","UserId");


   include_once "../header.php";
?>
         
        
 
        <div id="order">

        filter by:
        <select id="selectBox" onchange="filter_product(value)">
        <optgroup label="products">
        <option value="" disabled selected>Select your date</option>
        <option value="all" >Select All date</option>
         <?php
              
                for($i=0;$i<count($obj3->arry_object);$i++)
                {
           
                  echo '<option value='.$obj3->arry_object[$i].'>'.$obj3->arry_object[$i].'</option>';
                }
            
          
         ?>
          </optgroup>
        </select> 
     
   <table >
     <tr>
       <th>Order Id</th>
       <th> User</th>
       <th> Date</th>
       <th> Print</th>

     </tr>
   
     <?php
     
    //   echo count($obj->arry_object)."<br>";
    //   echo count($obj2->arry_object)."<br>";
    //  echo count($obj3->arry_object)."<br>";

     for ($i = 0; $i<count($obj->arry_object); $i++) 
     {
      
       echo "<tr>"."<td>".$obj->arry_object[$i]."</td>"."<td>".$obj2->arry_object[0] . "<td>" . $obj3->arry_object[$i] . "</td>"."<td>" .'<a href="printorder.php?Id='.Encryption::Encrypt($obj->arry_object[$i]).'">Print</a>'. "</td>" . "</tr>" . "</td>";
     }
     
     ?>
   </table>

    <?php

    
    ?>
   </div>
   <!-- the css for the add form -->
   <style>

    #a
    {
        margin-left: 20%;
        color:red;
    }
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

   <script>
    function filter_product(date)
{
    
   // alert(product_id);
   // return;
    if(date=="all")
    {
      location.reload();
      return;
    }
   var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
    if (this.readyState == 4 && this.status == 200) 
    {
     
      // document.getElementById("a").innerHTML=this.responseText;
     document.getElementById("order").innerHTML=this.responseText;
    }
  };
  xhttp.open("GET","All_orders.php?date="+date, true);
  xhttp.send();
}
    </script>
   <!-- -------------------------- -->
   <?php
   include_once "../footer.php";
   
   ?>