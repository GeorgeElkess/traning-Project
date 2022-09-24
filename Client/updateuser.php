<?php
if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION["UserId"])) {
    echo "<script>
            location.replace('/GitHub/traning-Project/Login/index.php');
        </script>";
    exit;
}
include_once "../includes.php"; 
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
 
$update_obj=new connection();
if($_POST["UserName"]!=$user_name->arry_object[0])
{
    $update_obj->updata("user",$_POST["UserName"],"UserName","Id",$user_id);
    
}
if($_POST["Email"]!=$Email->arry_object[0])
{
    $update_obj->updata("user",$_POST["Email"],"Email","Id",$user_id);
}
if($_POST["Password"]!="")
{
    if ($_POST["ConPassword"] != $_POST["Password"]) {
        echo  '<script>' .
        'alert("Password Not match the confirm password");history.go(-1);'
        . '</script>';
    } else {
        $update_obj->updata("user",sha1($_POST["Password"]),"Password","Id",$user_id);
    }
}
if($_POST["DateOfBirth"]!=$date->arry_object[0])
{
    $update_obj->updata("user",$_POST["DateOfBirth"],"DateOfBirth","Id",$user_id);
}
if($_POST["Phone"]!=$Phone->arry_object[0])
{
    $update_obj->updata("user",$_POST["Phone"],"Phone","Id",$user_id);
}
if($_POST["Address"]!=$Address->arry_object[0])
{
    $update_obj->updata("user",$_POST["Address"],"Address","Id",$user_id);
}
echo  '<script>'.
         'history.go(-1);'
         
         .'</script>';
?>
                        
                        