<?php
class connection extends PDO
{
    public $con;
    public $arry_object=array();
    public $i=0;
    
    public function __construct()
    {
        $this->con=new mysqli("127.0.0.1","root","","tranning project");
        if ($this->con-> connect_errno) 
        {
            echo "Failed to connect to MySQL: " .  $this->con -> connect_error;
            exit();
        }
    }
    public function getlastitem($table_name,$colom_name)
    {
      $sql ="SELECT MAX($colom_name) AS max_page FROM $table_name";
      $result=$this->con->query($sql);
      $row= $result -> fetch_assoc();
      return $row["max_page"]+1;

        // $sql="SELECT MAX($colom_name) FROM  $table_name";
        // $result=$this->con->query($sql);
        // while($row= $result -> fetch_assoc())
        // {
        //   $this->arry_object[$this->i]=$row[$colom_name];
        //   $this->i++;      
        // }
        // if($this->i>0)
        // {
        // $result=$this->arry_object[$this->i-1]+1;
        // return  $result;
        // }
    }

    public function get_min($table_name,$colom_name)
    {
      $sql ="SELECT MIN($colom_name) AS max_page FROM $table_name";
      $result=$this->con->query($sql);
      $row= $result -> fetch_assoc();
      return $row["max_page"];
    }

    public function max($table_name,$colom_name)
    {
      $sql ="SELECT MAX($colom_name) AS max_page FROM $table_name";
      $result=$this->con->query($sql);
      $row= $result -> fetch_assoc();
      return $row["max_page"];
    }

    public function returncolom($table_name,$colom_name,$orderby)
    {
        $sql="SELECT {$colom_name} FROM  $table_name ORDER BY {$orderby}  ASC";
        $result=$this->con->query($sql);
        while($row= $result -> fetch_assoc())
        {
          $this->arry_object[$this->i]=$row[$colom_name];
          $this->i++;      
        }
        
    }
    public function Like_as($table_name,$colom_name,$colom_name2,$search_word)
    {
      $sql="SELECT {$colom_name} FROM  {$table_name} WHERE {$colom_name2} LIKE '%$search_word%'";
      $result=$this->con->query($sql);
      while($row= $result -> fetch_assoc())
      {
        $this->arry_object[$this->i]=$row[$colom_name];
        $this->i++;      
      }
        
    }
    // public function return_special_colom2($table_name,$vale,$colom_name,$search_colom,$vale2)
    // {
    //   $sql="SELECT {$colom_name}  FROM {$table_name} WHERE {$search_colom}=$vale AND orderid=$vale2" ;
    //   $result=$this->con->query($sql);
    //   while($row= $result -> fetch_assoc())
    //   { 
    //     $this->arry_object[$this->i]=$row[$colom_name];
    //  //   echo $row[$colom_name]."<hr>";
    //     $this->i++;
    //   }     
    // }
    public function return_special_colom($table_name,$vale,$colom_name,$search_colom)
    {
      $sql="SELECT {$colom_name}  FROM {$table_name} WHERE {$search_colom}='$vale'";
      $result=$this->con->query($sql);
      while($row= $result -> fetch_assoc())
      { 
        $this->arry_object[$this->i]=$row[$colom_name];
        //echo $row[$colom_name]."<hr>";
        $this->i++;
      }     
    }
   
    public function return_special_colom3($table_name,$vale,$colom_name,$search_colom,$search_colom2,$vale2)
    {
      $sql="SELECT {$colom_name}  FROM {$table_name} WHERE {$search_colom}='$vale' AND {$search_colom2}='$vale2'";
      //echo $sql."<br>";
      $result=$this->con->query($sql);
      while($row= $result -> fetch_assoc())
      { 
        $this->arry_object[$this->i]=$row[$colom_name];
        //echo $row[$colom_name]."<hr>";
        $this->i++;
      }     
    }

    public function betwen_to_values($table_name,$vale,$colom_name,$search_colom,$search_colom2,$vale2)
    {
      $sql="SELECT {$colom_name}  FROM {$table_name} WHERE {$search_colom}>'$vale' AND {$search_colom2}<='$vale2'";
     // echo $sql."<br>";
      $result=$this->con->query($sql);
      while($row= $result -> fetch_assoc())
      { 
        $this->arry_object[$this->i]=$row[$colom_name];
        //echo $row[$colom_name]."<hr>";
        $this->i++;
      }     
    }
    //-----------------login--------------------------------
   
    public function login($id,$password)
    {
      $sql="SELECT usertype  FROM loginn WHERE passwords= '$password'";
      $result=$this->con->query($sql);
      while($row= $result ->fetch_assoc())
      { 
          return $row["usertype"];
      } 
       return false;   
    }
    
    //-----------------insert-----------------------------
    public function insert($table_name,$data)
    {
        $sql="insert into {$table_name} values {$data}";
        //  echo $sql;
        $result=$this->con->query($sql);
    }
    //--------------updata---------------------------
    public function updata($table_name,$new_vale,$colom_set,$colom_name,$vale)
    {
         $sql="UPDATE $table_name SET $colom_set= '$new_vale' WHERE $colom_name = '$vale'";
        //  echo $sql;
         $result=$this->con->query($sql);
    }
    public function updata_2_con($table_name,$new_vale,$colom_set,$colom_name,$vale,$search_colom2,$vale2)
    {
         $sql="UPDATE $table_name SET $colom_set= '$new_vale' WHERE $colom_name = '$vale'AND {$search_colom2}='$vale2' ";
         //echo $sql;
         $result=$this->con->query($sql);
    }
    //--------------------update as like---------------------------------
    public function update_like($table_name,$new_vale,$colom_set,$colom_name,$search_word)
    {
      $sql="UPDATE $table_name SET $colom_set= '$new_vale' WHERE {$colom_name} LIKE '%$search_word%'";
      //echo $sql;
      $result=$this->con->query($sql);
    }
    //----------------------update the word
    public function update_word($table_name,$new_vale,$colom_set,$colom_name,$search_word)
    {
      $sql="UPDATE {$table_name} SET {$colom_set} = replace({$colom_set}, '$search_word', '$new_vale')";
      echo $sql;
      $result=$this->con->query($sql);
    }
   //---------------------delete----------------------------------
   public function delete($table_name,$vale,$colom_name)
   {
         $sql=" DELETE FROM $table_name WHERE $colom_name='$vale'";
        //  echo $sql;
         $result=$this->con->query($sql);
   
   }

    function __destruct()
    {
        $this->con->close();
    } 
}

 