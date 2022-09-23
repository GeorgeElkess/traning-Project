<?php 
include_once "../includes.php";

/// Order Id
   $Id=$_GET["Id"];
   $Id=1;
   $obj=new connection();
   $obj->return_special_colom("orders",$Id,"UserId","Id");
   if(count($obj->arry_object)==0)
   { 
    include_once "../header.php";
    echo "NO Order with id: ".$Id;
    include_once "../footer.php";
   
    exit;

   }

//    get adderrs
 $obj8=new connection();
 $obj8->return_special_colom("user",$obj->arry_object[0],"Address","Id");
   if(count($obj->arry_object)>0)
   {
    // user name
    $obj2=new connection();
    $obj2->return_special_colom("user",$obj->arry_object[0],"UserName","Id");
    //Date
    $obj3=new connection();
    $obj3->return_special_colom("orders",$Id,"Date","Id");
    
    //from orderdetails
    $obj4=new connection();
    $obj4->return_special_colom("orderdetails",$Id,"ProductId","OrderId");
    //get the name of product
    $obj5=new connection();
    //get all price 
    $obj6=new connection();
    //get the count of the product
    $obj7=new connection();
    for($i=0;$i<count($obj4->arry_object);$i++)
    {
        //all product name
        $obj5->return_special_colom("product",$obj4->arry_object[$i],"Name","Id");
       //   all price
      $obj6->return_special_colom("orderdetails",$obj4->arry_object[$i],"CurrentPrice","ProductId");
      //count 
      $obj7->return_special_colom("orderdetails",$obj4->arry_object[$i],"Number","ProductId");

        
    }
   }
     

   if (session_id() == '') {
     session_start();
   }
   include_once "../includes.php";
   include_once "../header.php";
    
   
    echo  '<div id="a">'."  All orders for".$obj2->arry_object[0].'</div>'."<br>";
    echo  '<div id="a">'. "  the Address is :".$obj8->arry_object[0].'</div>'."<br>";
    echo  '<div id="a">'. "  the date is :".$obj3->arry_object[0].'</div>'."<br>";

   ?>

   <table>
     <tr>
       <th> product name</th>
       <th> price</th>
       <th> Amount</th>

     </tr>
   
     <?php
     
    //  echo count($obj5->arry_object)."<br>";
    //  echo count($obj6->arry_object)."<br>";
    //  echo count($obj7->arry_object)."<br>";
     for ($i = 0; $i<count($obj5->arry_object); $i++) 
     {
      
       echo "<tr>"."<td>".$obj5->arry_object[$i]."</td>"."<td>".$obj6->arry_object[$i] . "<td>" . $obj7->arry_object[$i] . "</td>" . "</tr>" . "</td>";
     }
     $total_price=0;
     for ($i = 0; $i < count($obj6->arry_object); $i++) 
     {
        $total_price+=$obj6->arry_object[$i]*$obj7->arry_object[$i];
     }

     ?>
   </table>
    <?php

      echo  '<div id="a">'."total price is :".$total_price." $".'</div>';
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

    



