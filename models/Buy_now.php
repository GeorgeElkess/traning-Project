<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/GitHub/traning-Project/models/data_base_ali.php";
  
class Add_to_card
{
    
    static function Add_product($product_id,$count)
    {

        if($product_id!=null&&$count>0)
        {


            $obj=new connection();
            $obj->return_special_colom("card",$product_id,"count","product_id");
            if(count($obj->arry_object)!=0)
            {
                $obj->arry_object[0]+=$count;
                $obj->updata("card", $obj->arry_object[0],"count","product_id",$product_id);
                return;
            }
            $lastid=$obj->getlastitem("card","Id");
            $data="($lastid,$product_id,$count)";
            $obj->insert("card",$data);
        }
    }
    static function remove_product($product_id)
    {
        if($product_id!=null)
        {
        $obj=new connection();
        $obj->delete("card",$product_id,"product_id");   
        }
    }

}
// $obj=new Add_to_card();
// $obj->Add_product(1);
// $obj->Add_product(2);
// $obj->Add_product(3);
// $obj->Add_product(4);
// $obj->remove_product(3);
// for($i=0;$i<count($obj->arry_object);$i++)
// {
//     echo $obj->arry_object[$i]."<br>";
// }