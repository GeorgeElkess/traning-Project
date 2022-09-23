<?php
include_once "orders.php";
include_once "dbmanger.php";
include_once "usertype.php";
class User
{
	private $Id = 0;
	function getId() {
		return $this->Id;
	}
	function setId($Id) {
		$this->Id = floatval($Id);
	}
	private $TypeId = 0;
	function getTypeId() {
		return $this->TypeId;
	}
	function setTypeId($TypeId) {
		$this->TypeId = floatval($TypeId);
	}
	private $UserName = "";
	function getUserName() {
		return $this->UserName;
	}
	function setUserName($UserName) {
		$this->UserName = $UserName;
	}
	private $Password = "";
	function getPassword() {
		return $this->Password;
	}
	function setPassword($Password) {
		$this->Password = $Password;
	}
	private $Email = "";
	function getEmail() {
		return $this->Email;
	}
	function setEmail($Email) {
		$this->Email = $Email;
	}
	private $DateOfBirth = "";
	function getDateOfBirth() {
		return $this->DateOfBirth;
	}
	function setDateOfBirth($DateOfBirth) {
		$this->DateOfBirth = $DateOfBirth;
	}
	private $Phone = "";
	function getPhone() {
		return $this->Phone;
	}
	function setPhone($Phone) {
		$this->Phone = $Phone;
	}
	private $Address = "";
	function getAddress() {
		return $this->Address;
	}
	function setAddress($Address) {
		$this->Address = $Address;
	}
	public function __construct($Id=null,$TypeId=null,$UserName=null,$Password=null,$Email=null,$DateOfBirth=null,$Phone=null,$Address=null, $CreatedAt = null, $UpdatedAt = null) {
		if($Id!=null) $this->setId($Id);
		if($TypeId!=null) $this->setTypeId($TypeId);
		if($UserName!=null) $this->setUserName($UserName);
		if($Password!=null) $this->setPassword($Password);
		if($Email!=null) $this->setEmail($Email);
		if($DateOfBirth!=null) $this->setDateOfBirth($DateOfBirth);
		if($Phone!=null) $this->setPhone($Phone);
		if($Address!=null) $this->setAddress($Address);
		if ($CreatedAt != null) $this->setCreatedAt($CreatedAt);
		if ($UpdatedAt != null) $this->setUpdatedAt($UpdatedAt);
	}
	public function Equals(User $var) {
		if($this->TypeId!=$var->getTypeId()) return false;
		if($this->UserName!=$var->getUserName()) return false;
		if($this->Password!=$var->getPassword()) return false;
		if($this->Email!=$var->getEmail()) return false;
		if($this->DateOfBirth!=$var->getDateOfBirth()) return false;
		if($this->Phone!=$var->getPhone()) return false;
		if($this->Address!=$var->getAddress()) return false;
		return true;
	}
	public function AllIsSet() {
		if($this->TypeId == 0) return false;
		if($this->UserName == "") return false;
		if($this->Password == "") return false;
		if($this->Email == "") return false;
		if($this->DateOfBirth == "") return false;
		if($this->Phone == "") return false;
		if($this->Address == "") return false;
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
class UserManger {
private function __construct() { }
	public static function Add(User $Info) {
		if(!$Info->AllIsSet()) return false;
		if(!UserTypeManger::GetById($Info->getTypeId())) return false;
		$AllData = UserManger::GetAll();
		$LastId = 0;
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
				$LastId = $Data->getId();
			}
		}
		$Table = new TableManger("User");
		$Insert = new InsertStatment($LastId + 1);
		$Insert->Attach($Info->getTypeId());
		$Insert->Attach($Info->getUserName());
		$Insert->Attach($Info->getPassword());
		$Insert->Attach($Info->getEmail());
		$Insert->Attach($Info->getDateOfBirth());
		$Insert->Attach($Info->getPhone());
		$Insert->Attach($Info->getAddress());
		$Insert->Attach(date("y-m-d"));
		$Insert->Attach("");
		$Table->Insert($Insert);
		return true;
	}
	public static function Update(int $Id,User $Info) {
		$OldData = UserManger::GetById($Id);
		if(!$OldData) return false;
		$Condition = new Condition("Id", $Id);
		$Set = new SetStatment();
		if($Info->getTypeId()!=0) $Set->Attach("TypeId", $Info->getTypeId());
		else $Info->setTypeId($OldData->getTypeId());
		if($Info->getUserName()!="") $Set->Attach("UserName", $Info->getUserName());
		else $Info->setUserName($OldData->getUserName());
		if($Info->getPassword()!="") $Set->Attach("Password", $Info->getPassword());
		else $Info->setPassword($OldData->getPassword());
		if($Info->getEmail()!="") $Set->Attach("Email", $Info->getEmail());
		else $Info->setEmail($OldData->getEmail());
		if($Info->getDateOfBirth()!="") $Set->Attach("DateOfBirth", $Info->getDateOfBirth());
		else $Info->setDateOfBirth($OldData->getDateOfBirth());
		if($Info->getPhone()!="") $Set->Attach("Phone", $Info->getPhone());
		else $Info->setPhone($OldData->getPhone());
		if($Info->getAddress()!="") $Set->Attach("Address", $Info->getAddress());
		else $Info->setAddress($OldData->getAddress());
		if(!UserTypeManger::GetById($Info->getTypeId())) return false;
		$AllData = UserManger::GetAll();
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
			}
		}
		$Set->Attach("UpdatedAt", date("y-m-d"));
		$Table = new TableManger("User");
		$Table->Update($Condition, $Set);
		return true;
	}
	public static function GetAll(User $Info = null) {
		$Result = [];
		$Condition = new Condition();
		if($Info != null) {
			if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
			if ($Info->getTypeId() != 0) $Condition->Attach("TypeId", $Info->getTypeId());
			if ($Info->getUserName() != "") $Condition->Attach("UserName", $Info->getUserName());
			if ($Info->getPassword() != "") $Condition->Attach("Password", $Info->getPassword());
			if ($Info->getEmail() != "") $Condition->Attach("Email", $Info->getEmail());
			if ($Info->getDateOfBirth() != "") $Condition->Attach("DateOfBirth", $Info->getDateOfBirth());
			if ($Info->getPhone() != "") $Condition->Attach("Phone", $Info->getPhone());
			if ($Info->getAddress() != "") $Condition->Attach("Address", $Info->getAddress());
		}
		$Table = new TableManger("User");
		$AllData = $Table->GetAll($Condition);
		if (count($AllData) == 0) return false;
		foreach ($AllData as $Row) {
			array_push($Result, new User($Row["Id"], $Row["TypeId"], $Row["UserName"], $Row["Password"], $Row["Email"], $Row["DateOfBirth"], $Row["Phone"], $Row["Address"], $Row["CreatedAt"], $Row["UpdatedAt"]));
		}
		return $Result;
	}
	public static function GetById(int $Id) {
		$AllData = UserManger::GetAll(new User($Id));
		if ($AllData == false) return false;
		return $AllData[0];
	}
	public static function Delete(User $Info) {
		if(!UserManger::GetAll($Info)) return false;
		$Condition = new Condition();
		if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
		if ($Info->getTypeId() != 0) $Condition->Attach("TypeId", $Info->getTypeId());
		if ($Info->getUserName() != "") $Condition->Attach("UserName", $Info->getUserName());
		if ($Info->getPassword() != "") $Condition->Attach("Password", $Info->getPassword());
		if ($Info->getEmail() != "") $Condition->Attach("Email", $Info->getEmail());
		if ($Info->getDateOfBirth() != "") $Condition->Attach("DateOfBirth", $Info->getDateOfBirth());
		if ($Info->getPhone() != "") $Condition->Attach("Phone", $Info->getPhone());
		if ($Info->getAddress() != "") $Condition->Attach("Address", $Info->getAddress());
		$Table = new TableManger("User");
		$Data = new Orders();
		$Data->setUserId($Info->getId());
		$AllData = OrdersManger::GetAll($Data);
		if($AllData!=false) {
			foreach($AllData as $Data) {
				OrdersManger::Delete(new Orders($Data->getId()));
			}
		}
		$Table->Delete($Condition);
		return true;
	}
}
