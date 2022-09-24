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
include_once "../models/user.php";
include_once "../header.php";
include_once "../includes.php";

// take the id of the user bu sesstion
   $user_id=$_SESSION["UserId"];
   $user_name=new connection();
   $Email=new connection();
   $password=new connection();
   $date=new connection();
   $Phone=new connection();
    $Address=new connection();

    $user_name->return_special_colom("user",$user_id,"UserName","Id");
    if($user_name->i==0){return;}
    $Email->return_special_colom("user",$user_id,"Email","Id");
    $password->return_special_colom("user",$user_id,"Password","Id");
    $date->return_special_colom("user",$user_id,"DateOfBirth","Id");
    $Phone->return_special_colom("user",$user_id,"Phone","Id");
    $Address->return_special_colom("user",$user_id,"Address","Id");
   



?>
<!--  contact -->
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Profile</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <form id="request" class="main_form" method="POST" action="updateuser.php">
                    <div class="row">
                        <div class="col-md-12">
                            <input class="contactus"   placeholder="UserName"  value="<?php echo $user_name->arry_object[0] ?>" type="text" name="UserName">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Email"     value="<?php echo $Email->arry_object[0] ?>" type="Email" name="Email">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus"  id="pass"  onkeyup="password(this.value) "  placeholder="Password" type="password" name="Password">
                        </div> 
                        <div class="col-md-12">
                            <input class="contactus" id="confrim"   onkeyup="check(this.value) " placeholder="Confirm Password"    type="password" name="ConPassword">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Date of Birth"  value="<?php echo $date->arry_object[0] ?>" type="Date" name="DateOfBirth">
                        </div>
                        <div class="col-md-12">
                            <input class="contactus" placeholder="Phone"  value="<?php echo $Phone->arry_object[0] ?>" type="text" name="Phone">
                        </div>
                        <div class="col-md-12">
                            <textarea class="textarea"  type="text" name="Address"><?php echo $Address->arry_object[0];?></textarea>
                        </div>
                        <div class="col-md-12">
                            <button class="send_btn">Update Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>


   
   function password(inputtx) 
    {
        // alert(inputtx);

        let text =inputtx;
       let code = text.charCodeAt(0);
       
  if (isNaN(code)) 
  {
    
   
    var elem = document.getElementById('confrim');
    if(elem.hasAttribute('required'))
    {
           
        
    const input = document.getElementById('confrim');
    input.removeAttribute('required');
    }
   
  }
  else
  {
     
     const input = document.getElementById('confrim');
     input.setAttribute('required', '');

    }
}

    function check(inputtx) 
     {
      code = inputtx.charCodeAt(0);
    //     alert(code)
     
    if (isNaN(code)) 
    {
        var elem = document.getElementById('pass').value;
        if(elem==passwor)
        {
          
        }
        else
        {
            
            document.getElementById('confrim').value="";  
            const input = document.getElementById('confrim');
            input.setAttribute('required', '');  
            alert("your confirm password no equl to password pleas fill again")
        }
    }

    }

</script>





<!-- end contact -->
<?php
include_once "../footer.php";
