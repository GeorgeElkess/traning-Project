<?php include_once "../includes.php"; 
  

   // here make php filter get the data and return to ajax to the same page
  
   if(isset($_GET["product_id"]))
    {
      ?>
       <div  id="product_id" class="products">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="titlepage">
                  <h2>Our Products</h2>
               </div>
            </div>
         </div>
  <!-- her will make the filter -->
        filter by:
        <select id="selectBox" onchange="filter_product(value)">
        <optgroup label="products">
        <option value="" disabled selected>Select your product</option>
         <?php
           $AllData = ProductCategoryManger::GetAll();
           if($AllData!=false)
           {
            foreach ($AllData as $Data) 
            {
                  echo '<option value='.$Data->getId().'>'.$Data->getName().'</option>';
            }
          }
         ?>
          </optgroup>
        </select>

         <div class="row">
            <div class="col-md-12">
               <div class="our_products">
                  <div class="row">
                     <?php
                            
                        $obj=new connection();
                        $obj2=new connection();
                        $obj3=new connection();
                        $obj3->return_special_colom("product",$_GET["product_id"],"Id","CategoryId");
                        $obj->return_special_colom("product",$_GET["product_id"],"Name","CategoryId");
                        $obj2->return_special_colom("product",$_GET["product_id"],"ImagePath","CategoryId");
                        for($i=0;$i<count($obj->arry_object);$i++)
                        {
                           ?>
                             
                             <div  class="col-md-4 margin_bottom1">
                              <div   class="product_box">
                                 <a href="show_product_details.php?id_product=<?php echo $obj3->arry_object[$i];?>">
                                 <figure><img src="<?php echo $obj2->arry_object[$i];?>" alt="#" /></figure>
                                 <h3><?php echo $obj->arry_object[$i];?></h3>
                                 </a>
                              </div>
                           </div>
                           
                           <?php
                        }
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
      <?php
      return;
    }


    if(isset($_GET["delete_id"]))
    {
      Add_to_card::remove_product($_GET["delete_id"]);

      ?>
       <!-- here will make the cart  -->
 <?php
     //session_start();
    if(isset($_REQUEST["card"]))
    {
     
    ?>
<div id="menu">
  <ul>
   <h3>your cart</h3>
   <hr>
   <?php
      $total_payed=0;
       $obj=new connection();
       $obj->returncolom("card","product_id","product_id");

      

       $obj3=new connection();
       $obj3->returncolom("card","count","product_id");
       for($i=0;$i<count($obj->arry_object);$i++)
       {
         $obj2=new connection();
         $obj2->return_special_colom("product",$obj->arry_object[$i],"Name","Id");

         $obj4=new connection();
         $obj4->return_special_colom("product",$obj->arry_object[$i],"Price","Id");
         echo '<li><a href="">'.$obj2->arry_object[0]."  x".$obj3->arry_object[$i].'</a>'.'<button class="button-5"  onclick="delete_product('.$obj->arry_object[$i].')" role="button">x</button>'.'</li>'.'<br>';
         $total_payed+=$obj4->arry_object[0]*$obj3->arry_object[$i];
         
      }
      echo "<hr>";
      echo 'total payed: '.$total_payed.' $'.'<br>';
   ?>
   <hr>
   <button class="button-6" role="button">Buy now</button>
  </ul>
</div>
    <?php
    }
    else
    {
      echo "nooo";
    }
    ?>
      <?php
      return;
    }
  
//<!-- -------------------------------------------------------------------- -->


 include_once "../header.php";






?>


   <!-- here will make the cart  -->
 <?php
     //session_start();
    if(isset($_REQUEST["card"]))
    {
     
    ?>
<div id="menu">
  <ul>
   <h3>your cart</h3>
   <hr>
   <?php
      $total_payed=0;
       $obj=new connection();
       $obj->returncolom("card","product_id","product_id");

      

       $obj3=new connection();
       $obj3->returncolom("card","count","product_id");
       for($i=0;$i<count($obj->arry_object);$i++)
       {
         $obj2=new connection();
         $obj2->return_special_colom("product",$obj->arry_object[$i],"Name","Id");

         $obj4=new connection();
         $obj4->return_special_colom("product",$obj->arry_object[$i],"Price","Id");
         echo '<li><a href="">'.$obj2->arry_object[0]."  x".$obj3->arry_object[$i].'</a>'.'<button class="button-5"  onclick="delete_product('.$obj->arry_object[$i].')" role="button">x</button>'.'</li>'.'<br>';
         $total_payed+=$obj4->arry_object[0]*$obj3->arry_object[$i];
         
      }
      echo "<hr>";
      echo 'total payed: '.$total_payed.' $'.'<br>';
   ?>
   <hr>
   <button class="button-6" role="button">Buy now</button>
  </ul>
</div>
    <?php
    }
    else
    {
      
    }
    ?>



   <!-- products -->
   <div  id="product_id" class="products">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="titlepage">
                  <h2>Our Products</h2>
               </div>
            </div>
         </div>
  <!-- her will make the filter -->
        filter by:
        <select id="selectBox" onchange="filter_product(value)">
        <optgroup label="products">
        <option value="" disabled selected>Select your product</option>
         <?php
           $AllData = ProductCategoryManger::GetAll();
           if($AllData!=false)
           {
            foreach ($AllData as $Data) 
            {
                  echo '<option value='.$Data->getId().'>'.$Data->getName().'</option>';
            }
          }
         ?>
          </optgroup>
        </select>

         <div class="row">
            <div class="col-md-12">
               <div class="our_products">
                  <div class="row">
                     <?php
                     // i is the driver for the arry carry the all id
                     $i=0;
                     $obj=new connection();
                     $obj->returncolom("product","Id","Id");
                     
                     $AllData = ProductManger::GetAll();
                     if($AllData!=false){
                        foreach ($AllData as $Data) {
                        ?>
                           <div   class="col-md-4 margin_bottom1">
                              <div   class="product_box">
                                 <a href="show_product_details.php?id_product=<?php echo Encryption::Encrypt($obj->arry_object[$i]);?>">
                                 <figure><img src="<?php echo $Data->getImagePath()?>" alt="#" /></figure>
                                 <h3><?php echo $Data->getName();?></h3>
                                 </a>
                              </div>
                           </div>
                        <?php
                         $i++;
                        }
                     }
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end products -->

 


   <?php
   include_once "../footer.php";
   ?>

  
   <!-- here  make the Ajax and get the data from the same page by send the id of category with url -->

   <script>
function filter_product(product_id)
{
    
   // alert(product_id);
   // return;
   var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
    if (this.readyState == 4 && this.status == 200) 
    {
     
      // document.getElementById("a").innerHTML=this.responseText;
     document.getElementById("product_id").innerHTML=this.responseText;
    }
  };
  xhttp.open("GET","product.php?product_id="+product_id, true);
  xhttp.send();
}


function delete_product(product_id)
{
   // alert(product_id);
   //  return;
   var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
    if (this.readyState == 4 && this.status == 200) 
    {
     
        document.getElementById("menu").innerHTML=this.responseText;
   //   document.getElementById("product_id").innerHTML=this.responseText;
    }
  };
  xhttp.open("GET","product.php?delete_id="+product_id+"&card=1", true);
  xhttp.send();
}
   </script>






<style>
   body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 80%;
	font-weight: bold;
	width: 100%;
	}	

h1 {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:16px;
	font-weight:bold;
	margin:0;
	padding:0;
	}

hr {
	border:none;
	border-top:1px solid #f1841d;
	height:1px;
	margin-bottom:25px;
	}

ul {
	list-style: none;
	margin: 0;
	padding: 0;
	}
	
#menu {
	width: 500px;
	margin-top: 10px;
   background-color:#d5f4e6;
   border-style: solid;

	}



.button-5 {
  align-items: center;
  background-clip: padding-box;
  background-color:red;
  border: 1px solid transparent;
  border-radius: .25rem;
  box-shadow: rgba(225, 0, 0, 0) 0 1px 3px 0;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  display: inline-flex;
  font-family: system-ui,-apple-system,system-ui,"Helvetica Neue",Helvetica,Arial,sans-serif;
  font-size: 10px;
  font-weight: 10;
  justify-content: center;
  line-height: 1.25;
  margin-left: 50%;
  min-height: 3rem;
  padding: calc(.875rem - 1px) calc(1.5rem - 1px);
  position: relative;
  text-decoration: none;
  transition: all 250ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: baseline;
  width: auto;
}
.button-6 {
  align-items: center;
  background-clip: padding-box;
  background-color: #fa6400;
  border: 1px solid transparent;
  border-radius: .25rem;
  box-shadow: rgba(0, 0, 0, 0.02) 0 1px 3px 0;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  display: inline-flex;
  font-family: system-ui,-apple-system,system-ui,"Helvetica Neue",Helvetica,Arial,sans-serif;
  font-size: 16px;
  font-weight: 600;
  justify-content: center;
  line-height: 1.25;
  margin: 0;
  min-height: 3rem;
  padding: calc(.875rem - 1px) calc(1.5rem - 1px);
  position: relative;
  text-decoration: none;
  transition: all 250ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: baseline;
  width: auto;
}

.button-5:hover,
.button-5:focus {
  background-color: #fb8332;
  box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
}

.button-5:hover {
  transform: translateY(-1px);
}

.button-5:active {
  background-color: #c85000;
  box-shadow: rgba(0, 0, 0, .06) 0 2px 4px;
  transform: translateY(0);
}


   </style>


</body>

</html>