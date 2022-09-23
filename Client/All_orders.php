<?php

// if (session_id() == '') {
//     session_start();
// }
include_once "../includes.php";

/// Order Id
//    $Id=$_GET["Id"];
      $user_id=1;
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
   $obj3->return_special_colom("orderdetails",$obj->arry_object[0],"CreatedAt","Id");


   include_once "../header.php";
?>
<table>
     <tr>
       <th>Order Id</th>
       <th> User</th>
       <th> Date</th>
       <th> Print</th>

     </tr>
   
     <?php
     
    //  echo count($obj->arry_object)."<br>";
    //  echo count($obj2->arry_object)."<br>";
    //  echo count($obj3->arry_object)."<br>";

     for ($i = 0; $i<count($obj->arry_object); $i++) 
     {
      
       echo "<tr>"."<td>".$obj->arry_object[$i]."</td>"."<td>".$obj2->arry_object[$i] . "<td>" . $obj3->arry_object[$i] . "</td>"."<td>" .'<a href="printorder.php?Id='.$obj->arry_object[$i].'">Print</a>'. "</td>" . "</tr>" . "</td>";
     }
     
     ?>
   </table>
    <?php

    
    ?>
   
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
   <!-- -------------------------- -->
   <?php
   include_once "../footer.php";
   
   ?>