<?php
include_once "productcategoryoption.php";
include_once "dbmanger.php";
class Options
{
	private $Id = 0;
	function getId() {
		return $this->Id;
	}
	function setId($Id) {
		$this->Id = floatval($Id);
	}
	private $Name = "";
	function getName() {
		return $this->Name;
	}
	function setName($Name) {
		$this->Name = $Name;
	}
	private $Type = "";
	function getType() {
		return $this->Type;
	}
	function setType($Type) {
		$this->Type = $Type;
	}
	private $CreatedAt = "";
	private $UpdatedAt = "";
	public function setCreatedAt($CreatedAt){
		$this->CreatedAt = $CreatedAt;
	}
	public function setUpdatedAt($UpdatedAt) {
		$this->UpdatedAt = $UpdatedAt;
	}
	public function getCreatedAt(){
		return $this->CreatedAt;
	}
	public function getUpdatedAt(){
		return $this->UpdatedAt;
	}
	public function __construct($Id=null,$Name=null,$Type=null,$CreatedAt=null,$UpdatedAt=null) {
		if($Id!=null) $this->setId($Id);
		if($Name!=null) $this->setName($Name);
		if($Type!=null) $this->setType($Type);
		if($CreatedAt!=null) $this->setCreatedAt($CreatedAt);
		if($UpdatedAt!=null) $this->setUpdatedAt($UpdatedAt);
	}
	public function Equals(Options $var) {
		if($this->Name!=$var->getName()) return false;
		if($this->Type!=$var->getType()) return false;
		return true;
	}
	public function AllIsSet() {
		if($this->Name == "") return false;
		if($this->Type == "") return false;
		return true;
	}
}
class OptionsManger {
private function __construct() { }
	public static function Add(Options $Info) {
		if(!$Info->AllIsSet()) return false;
		$AllData = OptionsManger::GetAll();
		$LastId = 0;
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
				$LastId = $Data->getId();
			}
		}
		$Table = new TableManger("Options");
		$Insert = new InsertStatment($LastId + 1);
		$Insert->Attach($Info->getName());
		$Insert->Attach($Info->getType());
		date_default_timezone_set("Egypt/Cairo");
		$Insert->Attach(date("y-m-d"));
		$Table->Insert($Insert);
		return true;
	}
	public static function Update(int $Id,Options $Info) {
		$OldData = OptionsManger::GetById($Id);
		if(!$OldData) return false;
		$Condition = new Condition("Id", $Id);
		$Set = new SetStatment();
		if($Info->getName()!="") $Set->Attach("Name", $Info->getName());
		else $Info->setName($OldData->getName());
		if($Info->getType()!="") $Set->Attach("Type", $Info->getType());
		else $Info->setType($OldData->getType());
		$AllData = OptionsManger::GetAll();
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
			}
		}
		date_default_timezone_set("Egypt/Cairo");
		$Set->Attach("UpdatedAt", date("y-m-d"));
		$Table = new TableManger("Options");
		$Table->Update($Condition, $Set);
		return true;
	}
	public static function GetAll(Options $Info = null) {
		$Result = [];
		$Condition = new Condition();
		if($Info != null) {
			if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
			if ($Info->getName() != "") $Condition->Attach("Name", $Info->getName());
			if ($Info->getType() != "") $Condition->Attach("Type", $Info->getType());
		}
		$Table = new TableManger("Options");
		$AllData = $Table->GetAll($Condition);
		if (count($AllData) == 0) return false;
		foreach ($AllData as $Row) {
			array_push($Result, new Options($Row["Id"], $Row["Name"], $Row["Type"],$Row["CreatedAt"],$Row["UpdatedAt"]));
		}
		return $Result;
	}
	public static function GetById(int $Id) {
		$AllData = OptionsManger::GetAll(new Options($Id));
		if ($AllData == false) return false;
		return $AllData[0];
	}
	public static function Delete(Options $Info) {
		if(!OptionsManger::GetAll($Info)) return false;
		$Condition = new Condition();
		if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
		if ($Info->getName() != "") $Condition->Attach("Name", $Info->getName());
		if ($Info->getType() != "") $Condition->Attach("Type", $Info->getType());
		$Table = new TableManger("Options");
		$Data = new ProductCategoryOption();
		$Data->setOptionId($Info->getId());
		$AllData = ProductCategoryOptionManger::GetAll($Data);
		if($AllData!=false) {
			foreach($AllData as $Data) {
				ProductCategoryOptionManger::Delete(new ProductCategoryOption($Data->getId()));
			}
		}
		$Table->Delete($Condition);
		return true;
	}
}
