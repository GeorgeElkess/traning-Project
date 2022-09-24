<?php 
include_once "../includes.php"; 
 $user_id=1;
   $user_name=new connection();
   $Email=new connection();
   $password=new connection();
   $date=new connection();
   $Phone=new connection();
    $Address=new connection();

    $user_name->return_special_colom("user",1,"UserName","Id");
    if($user_name->i==0){return;}
    $Email->return_special_colom("user",1,"Email","Id");
    $password->return_special_colom("user",1,"Password","Id");
    $date->return_special_colom("user",1,"DateOfBirth","Id");
    $Phone->return_special_colom("user",1,"Phone","Id");
    $Address->return_special_colom("user",1,"Address","Id");
 
    if($_POST["ConPassword"]!=$_POST["Password"])
    {
         echo  '<script>'.
         'alert("your confirm password no equl to password pleas fill again");history.go(-1);'
         
         .'</script>';
         
    }
       $update_obj=new connection();
if($_POST["UserName"]!=$user_name->arry_object[0])
{
    $update_obj->updata("user",$_POST["UserName"],"UserName","Id",1);
    
}
if($_POST["Email"]!=$Email->arry_object[0])
{
    $update_obj->updata("user",$_POST["Email"],"Email","Id",1);
}
if($_POST["Password"]!=$password->arry_object[0])
{
    $update_obj->updata("user",$_POST["Password"],"Password","Id",1);
}
if($_POST["DateOfBirth"]!=$date->arry_object[0])
{
    $update_obj->updata("user",$_POST["DateOfBirth"],"DateOfBirth","Id",1);
}
if($_POST["Phone"]!=$Phone->arry_object[0])
{
    $update_obj->updata("user",$_POST["Phone"],"Phone","Id",1);
}
if($_POST["Address"]!=$Address->arry_object[0])
{
    $update_obj->updata("user",$_POST["Address"],"Address","Id",1);
}

echo  '<script>'.
         'history.go(-1);'
         
         .'</script>';
?>
                        
                        