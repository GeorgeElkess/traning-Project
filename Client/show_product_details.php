
<?php
   include_once "../includes.php";
     $id=Encryption::Decrypt($_REQUEST["id_product"]);
     $obj=new connection();
     $obj->return_special_colom("product",$id,"CategoryId","Id");
    
     $obj4=new connection();
     $obj4->return_special_colom("product",$id,"ImagePath","Id");

     $obje=new connection();
     $obje->return_special_colom("product",$id,"Name","Id");

     if(count( $obj->arry_object)==0){return;}
    $obj2=new connection();
    $obj2->return_special_colom("productcategoryoption",$obj->arry_object[0],"OptionId","CategoryId");
    

    $obj3=new connection();


    for($i=0;$i<count( $obj2->arry_object);$i++)
    {
        $obj3->return_special_colom("options",$obj2->arry_object[$i],"Name","Id");
    }
    
     ?>
<head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>cla</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>

   <body>
    
   

                            <div  class="col-md-4 margin_bottom1">
                              <div   class="product_box">
                                 
                                 <figure><img src="<?php echo $obj4->arry_object[0];?>" alt="#" /></figure>
                                 <h3><?php echo $obje->arry_object[0];?></h3>
                                 </a>
                              </div>
                           </div>
                           <hr>
     <?php

       

    $obj5=new connection();
    $obj5->return_special_colom("optionvalues",$id,"Value","ProductId");
   
    for($i=0;$i<count($obj3->arry_object);$i++)
    {
        if(count($obj5->arry_object)==$i){break;}
        echo  ' <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">'.$obj3->arry_object[$i].':  '.$obj5->arry_object[$i]."<br>".' </div>';
   
    }
   
   if(count($obj5->arry_object)==0)
   {
    echo ' <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">'."this product not avilable now".':'."<br>".' </div>';
    return;
   }
   
?>

<form action="core.php" method="GET">
<input type="hidden" name="product_id" value="<?php echo $id?>">
  enter the count :<input type="number" name="count"  required>
<button  type="submit">Add to card</button>
</form>


</body>


