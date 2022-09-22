<?php
include_once "orderdetails.php";
include_once "dbmanger.php";
include_once "user.php";
class Orders
{
	private $Id = 0;
	function getId() {
		return $this->Id;
	}
	function setId($Id) {
		$this->Id = floatval($Id);
	}
	private $UserId = 0;
	function getUserId() {
		return $this->UserId;
	}
	function setUserId($UserId) {
		$this->UserId = floatval($UserId);
	}
	private $Date = "";
	function getDate() {
		return $this->Date;
	}
	function setDate($Date) {
		$this->Date = $Date;
	}
	public function __construct($Id=null,$UserId=null,$Date=null, $CreatedAt = null, $UpdatedAt = null) {
		if($Id!=null) $this->setId($Id);
		if($UserId!=null) $this->setUserId($UserId);
		if($Date!=null) $this->setDate($Date);
		if ($CreatedAt != null) $this->setCreatedAt($CreatedAt);
		if ($UpdatedAt != null) $this->setUpdatedAt($UpdatedAt);
	}
	public function Equals(Orders $var) {
		if($this->UserId!=$var->getUserId()) return false;
		if($this->Date!=$var->getDate()) return false;
		return true;
	}
	public function AllIsSet() {
		if($this->UserId == 0) return false;
		if($this->Date == "") return false;
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
class OrdersManger {
private function __construct() { }
	public static function Add(Orders $Info) {
		if(!$Info->AllIsSet()) return false;
		if(!UserManger::GetById($Info->getUserId())) return false;
		$AllData = OrdersManger::GetAll();
		$LastId = 0;
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
				$LastId = $Data->getId();
			}
		}
		$Table = new TableManger("Orders");
		$Insert = new InsertStatment($LastId + 1);
		$Insert->Attach($Info->getUserId());
		$Insert->Attach($Info->getDate());
		date_default_timezone_set("Egypt/Cairo");
		$Insert->Attach(date("y-m-d"));
		$Table->Insert($Insert);
		return true;
	}
	public static function Update(int $Id,Orders $Info) {
		$OldData = OrdersManger::GetById($Id);
		if(!$OldData) return false;
		$Condition = new Condition("Id", $Id);
		$Set = new SetStatment();
		if($Info->getUserId()!=0) $Set->Attach("UserId", $Info->getUserId());
		else $Info->setUserId($OldData->getUserId());
		if($Info->getDate()!="") $Set->Attach("Date", $Info->getDate());
		else $Info->setDate($OldData->getDate());
		if(!UserManger::GetById($Info->getUserId())) return false;
		$AllData = OrdersManger::GetAll();
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
			}
		}
		date_default_timezone_set("Egypt/Cairo");
		$Set->Attach("UpdatedAt", date("y-m-d"));
		$Table = new TableManger("Orders");
		$Table->Update($Condition, $Set);
		return true;
	}
	public static function GetAll(Orders $Info = null) {
		$Result = [];
		$Condition = new Condition();
		if($Info != null) {
			if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
			if ($Info->getUserId() != 0) $Condition->Attach("UserId", $Info->getUserId());
			if ($Info->getDate() != "") $Condition->Attach("Date", $Info->getDate());
		}
		$Table = new TableManger("Orders");
		$AllData = $Table->GetAll($Condition);
		if (count($AllData) == 0) return false;
		foreach ($AllData as $Row) {
			array_push($Result, new Orders($Row["Id"], $Row["UserId"], $Row["Date"], $Row["CreatedAt"], $Row["UpdatedAt"]));
		}
		return $Result;
	}
	public static function GetById(int $Id) {
		$AllData = OrdersManger::GetAll(new Orders($Id));
		if ($AllData == false) return false;
		return $AllData[0];
	}
	public static function Delete(Orders $Info) {
		if(!OrdersManger::GetAll($Info)) return false;
		$Condition = new Condition();
		if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
		if ($Info->getUserId() != 0) $Condition->Attach("UserId", $Info->getUserId());
		if ($Info->getDate() != "") $Condition->Attach("Date", $Info->getDate());
		$Table = new TableManger("Orders");
		$Data = new OrderDetails();
		$Data->setOrderId($Info->getId());
		$AllData = OrderDetailsManger::GetAll($Data);
		if($AllData!=false) {
			foreach($AllData as $Data) {
				OrderDetailsManger::Delete(new OrderDetails($Data->getId()));
			}
		}
		$Table->Delete($Condition);
		return true;
	}
}
