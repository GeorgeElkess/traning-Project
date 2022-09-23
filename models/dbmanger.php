<?php
use LDAP\Result;
class Cell
{
    public $ColumnName = "";
    public $IsString = false;
    public $Value;
    public function __construct(string $ColumnName, $Value) {
        $this->ColumnName = $ColumnName;
        $this->Value = $Value;
        if(is_string($Value)) {
            $this->IsString = true;
        }
    }
}
class InsertStatment
{
    public $sql = [];
    public function __construct($Value = null) {
        if($Value!=null) $this->Attach($Value);
    }
    public function Attach($NewValue) {
        array_push($this->sql, new Cell("", $NewValue));
    }
    public function GenerateInsertStatment() {
        if (count($this->sql) == 0) return null;
        $Line = "";
        for ($i = 0; $i < count($this->sql); $i++) {
            if ($this->sql[$i]->IsString) $Line .= "'".$this->sql[$i]->Value."'";
            else $Line .= "".$this->sql[$i]->Value;
            if ($i < count($this->sql) - 1) $Line .= ", ";
        }
        return $Line;
    }
}
class Condition
{
    public $condition = [];
    public function __construct($columnName = null, $NewValue = null) {
        if($columnName!=null && $NewValue!=null) {
            $this->Attach($columnName, $NewValue);
        }
    }
    public function Attach($ColumnName, $NewValue) { 
        array_push($this->condition, new Cell($ColumnName, $NewValue));
    }
    public function GenerateCondition()  {
        if (count($this->condition) == 0) return null;
        $Line = "";
        for ($i = 0; $i < count($this->condition); $i++) {
            $Line .= $this->condition[$i]->ColumnName;
            if ($this->condition[$i]->IsString) $Line .= " Like '%". $this->condition[$i]->Value."%'";
            else $Line .= "= ".$this->condition[$i]->Value;
            if ($i < count($this->condition) - 1) $Line .= " and ";
        }
        return $Line;
    }
}
class SetStatment
{
    public $Set = [];
    public function __construct($columnName = null, $NewValue = null)
    {
        if ($columnName != null && $NewValue != null) {
            $this->Attach($columnName, $NewValue);
        }
    }
    public function Attach($ColumnName, $NewValue)
    {
        array_push($this->Set, new Cell($ColumnName, $NewValue));
    }
    public function GenerateSet()
    {
        if (count($this->Set) == 0) return null;
        $Line = "";
        for ($i = 0; $i < count($this->Set); $i++) {
            $Line .= $this->Set[$i]->ColumnName . "=";
            if ($this->Set[$i]->IsString) $Line .= "'" . $this->Set[$i]->Value . "'";
            else $Line .= "".$this->Set[$i]->Value;
            if ($i < count($this->Set) - 1) $Line .= ", ";
        }
        return $Line;
    }
}
class TableManger
{
    private $TableName="";
    private $SqlConnection;
    public function __construct($TableName) {
        $this->TableName = $TableName;
        $this->SqlConnection = new mysqli("localhost", "root", "", "tranning project");
    }
    public function GetAll(Condition $var = null) {
        $Condition = "";
        if($var!=null && count($var->condition)!=0) $Condition = $var->GenerateCondition();
        if($Condition == "") $SqlStatement = "Select * From " . $this->TableName;
        else $SqlStatement = "Select * From ".$this->TableName." Where ".$Condition;
        $Data = $this->SqlConnection->query($SqlStatement);
        $Array = [];
        while ($row = $Data->fetch_assoc()) {
            array_push($Array, $row);
        }
        return $Array;
    }
    public function Insert(InsertStatment $var) {
        $Data = $var->GenerateInsertStatment();
        $SqlStatement = "Insert Into ".$this->TableName." Values(".$Data.")";
        $this->SqlConnection->query($SqlStatement);
    }
    public function Delete(Condition $var = null) {
        $Condition = "";
        if ($var != null && count($var->condition) != 0) $Condition = $var->GenerateCondition();
        if($Condition == "") $SqlStatement = "Delete From ".$this->TableName;
        else $SqlStatement = "Delete From ".$this->TableName." Where ".$Condition;
        $this->SqlConnection->query($SqlStatement);
    }
    public function Update(Condition $Condition, SetStatment $Set) {
        $con = $Condition->GenerateCondition();
        $set = $Set->GenerateSet();
        $SqlStatement = "Update ".$this->TableName." Set ".$set." Where ".$con;
        $this->SqlConnection->query($SqlStatement);
    }
}




?>