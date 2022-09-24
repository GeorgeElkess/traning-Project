
<?php 
if (session_id() == '') {
    session_start();
}
if(!isset($_SESSION["UserId"])){
    echo "<script>
            location.replace('/GitHub/traning-Project/Login/index.php');
        </script>";
    exit;
}
   include_once "../includes.php";
     $id=Encryption::Decrypt($_REQUEST["id_product"]);
   //   echo $id;
     $obj=new connection();
     $obj->return_special_colom("product",$id,"CategoryId","Id");
    
     $obj4=new connection();
     $obj4->return_special_colom("product",$id,"ImagePath","Id");

     $obje=new connection();
     $obje->return_special_colom("product",$id,"Name","Id");

     $obje2=new connection();
     $obje2->return_special_colom("product",$id,"price","Id");

     $obje3=new connection();
     $obje3->return_special_colom("product",$id,"CategoryId","Id");

     if(count($obje3->arry_object)>0)
     {
      $obje4=new connection();
      $obje4->return_special_colom("productcategory",$obje3->arry_object[0],"Name","Id");
     }
     else
     {
      return;
     }

     if(count($obj->arry_object)==0){return;}
    $obj2=new connection();
    $obj2->return_special_colom("productcategoryoption",$obj->arry_object[0],"OptionId","CategoryId");
    

    $obj3=new connection();
    for($i=0;$i<count( $obj2->arry_object);$i++)
    {
        $obj3->return_special_colom("options",$obj2->arry_object[$i],"Name","Id");
    }
    

     if(count($obj->arry_object)==0||count($obj2->arry_object)==0||count($obj3->arry_object)==0||count($obj4->arry_object)==0||count($obje->arry_object)==0||count($obje2->arry_object)==0)
     {

     }
     ?>
      
   <body>
    

 <!-- 0000000000000000000000000000000000000000000000 -->



 <?php

include_once "../header.php";
include_once "../includes.php";

?>

<table class="ProductDetails">
    <tbody>
        <tr>
            <td class="ProductImageSection">
                <img src="<?php echo $obj4->arry_object[0];?>" alt="<?php echo $obje->arry_object[0]; ?>">
            </td>
            <td class="ProductDetailsSection">
                <h4>Category <?php echo $obje4->arry_object[0] ?></h4>
                <h2><?php echo  $obje->arry_object[0]?></h2>
                <hr>
                <div class="ProductPrice">
                    <sup>EGP</sup>
                    <h3><?php echo  $obje2->arry_object[0]?></h3>
                    <?php 
                    $obj5=new connection();
                    $obj5->return_special_colom("optionvalues",$id,"Value","ProductId");
                   
                    for($i=0;$i<count($obj3->arry_object);$i++)
                    {
                         echo "<hr>";
                        if(count($obj5->arry_object)==$i){break;}
                        echo  '<div class="ProductPrice">'.$obj3->arry_object[$i].':  '.$obj5->arry_object[$i]."<br>".' </div>';
                   
                    }
                    ?>
                    <hr>
                    <form action="core.php" method="GET">
                  <input type="hidden" name="product_id" value="<?php echo $id?>">
                  enter the count :<input type="number" name="count"  required>
                 <button  type="submit">Add to card</button>
                  </form>
                    <?php
                  //  if(count($obj5->arry_object)==0)
                  //  {
                  //   echo ' <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">'."this product not avilable now".':'."<br>".' </div>';
                  //   return;
                  //  }
                    ?>

                </div>

                <hr>
                <div>
                    
                </div>
            </td>
        </tr>
    </tbody>
    
</table>

<?php
include_once "../footer.php";
?>



</body>




