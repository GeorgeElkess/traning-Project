<?php
include_once "user.php";
include_once "dbmanger.php";
class UserType
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
	public function __construct($Id=null,$Name=null, $CreatedAt = null, $UpdatedAt = null) {
		if($Id!=null) $this->setId($Id);
		if($Name!=null) $this->setName($Name);
		if ($CreatedAt != null) $this->setCreatedAt($CreatedAt);
		if ($UpdatedAt != null) $this->setUpdatedAt($UpdatedAt);
	}
	public function Equals(UserType $var) {
		if($this->Name!=$var->getName()) return false;
		return true;
	}
	public function AllIsSet() {
		if($this->Name == "") return false;
		return true;
	}
	private $CreatedAt = "";
	private $UpdatedAt = "";
	public function setCreatedAt($CreatedAt)
	{
		$this->CreatedAt = $CreatedAt;
	}
	public function setUpdatedAt($UpdatedAt)
	{
		$this->UpdatedAt = $UpdatedAt;
	}
	public function getCreatedAt()
	{
		return $this->CreatedAt;
	}
	public function getUpdatedAt()
	{
		return $this->UpdatedAt;
	}
}
class UserTypeManger {
private function __construct() { }
	public static function Add(UserType $Info) {
		if(!$Info->AllIsSet()) return false;
		$AllData = UserTypeManger::GetAll();
		$LastId = 0;
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
				$LastId = $Data->getId();
			}
		}
		$Table = new TableManger("UserType");
		$Insert = new InsertStatment($LastId + 1);
		$Insert->Attach($Info->getName());
		$Insert->Attach(date("y-m-d"));
		$Insert->Attach("");
		$Table->Insert($Insert);
		return true;
	}
	public static function Update(int $Id,UserType $Info) {
		$OldData = UserTypeManger::GetById($Id);
		if(!$OldData) return false;
		$Condition = new Condition("Id", $Id);
		$Set = new SetStatment();
		if($Info->getName()!="") $Set->Attach("Name", $Info->getName());
		else $Info->setName($OldData->getName());
		$AllData = UserTypeManger::GetAll();
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
			}
		}
		$Set->Attach("UpdatedAt", date("y-m-d"));
		$Table = new TableManger("UserType");
		$Table->Update($Condition, $Set);
		return true;
	}
	public static function GetAll(UserType $Info = null) {
		$Result = [];
		$Condition = new Condition();
		if($Info != null) {
			if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
			if ($Info->getName() != "") $Condition->Attach("Name", $Info->getName());
		}
		$Table = new TableManger("UserType");
		$AllData = $Table->GetAll($Condition);
		if (count($AllData) == 0) return false;
		foreach ($AllData as $Row) {
			array_push($Result, new UserType($Row["Id"], $Row["Name"], $Row["CreatedAt"], $Row["UpdatedAt"]));
		}
		return $Result;
	}
	public static function GetById(int $Id) {
		$AllData = UserTypeManger::GetAll(new UserType($Id));
		if ($AllData == false) return false;
		return $AllData[0];
	}
	public static function Delete(UserType $Info) {
		if(!UserTypeManger::GetAll($Info)) return false;
		$Condition = new Condition();
		if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
		if ($Info->getName() != "") $Condition->Attach("Name", $Info->getName());
		$Table = new TableManger("UserType");
		$Data = new User();
		$Data->setTypeId($Info->getId());
		$AllData = UserManger::GetAll($Data);
		if($AllData!=false) {
			foreach($AllData as $Data) {
				UserManger::Delete(new User($Data->getId()));
			}
		}
		$Table->Delete($Condition);
		return true;
	}
}
