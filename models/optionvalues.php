<?php
include_once "dbmanger.php";
include_once "productcategoryoption.php";
include_once "product.php";
class OptionValues
{
	private $Id = 0;
	function getId() {
		return $this->Id;
	}
	function setId($Id) {
		$this->Id = floatval($Id);
	}
	private $PCOId = 0;
	function getPCOId() {
		return $this->PCOId;
	}
	function setPCOId($PCOId) {
		$this->PCOId = floatval($PCOId);
	}
	private $ProductId = 0;
	function getProductId() {
		return $this->ProductId;
	}
	function setProductId($ProductId) {
		$this->ProductId = floatval($ProductId);
	}
	private $Values = "";
	function getValues() {
		return $this->Values;
	}
	function setValues($Values) {
		$this->Values = $Values;
	}
	public function __construct($Id=null,$PCOId=null,$ProductId=null,$Values=null, $CreatedAt = null, $UpdatedAt = null) {
		if($Id!=null) $this->setId($Id);
		if($PCOId!=null) $this->setPCOId($PCOId);
		if($ProductId!=null) $this->setProductId($ProductId);
		if($Values!=null) $this->setValues($Values);
		if ($CreatedAt != null) $this->setCreatedAt($CreatedAt);
		if ($UpdatedAt != null) $this->setUpdatedAt($UpdatedAt);
	}
	public function Equals(OptionValues $var) {
		if($this->PCOId!=$var->getPCOId()) return false;
		if($this->ProductId!=$var->getProductId()) return false;
		if($this->Values!=$var->getValues()) return false;
		return true;
	}
	public function AllIsSet() {
		if($this->PCOId == 0) return false;
		if($this->ProductId == 0) return false;
		if($this->Values == "") return false;
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
class OptionValuesManger {
private function __construct() { }
	public static function Add(OptionValues $Info) {
		if(!$Info->AllIsSet()) return false;
		if(!ProductCategoryOptionManger::GetById($Info->getPCOId())) return false;
		if(!ProductManger::GetById($Info->getProductId())) return false;
		$AllData = OptionValuesManger::GetAll();
		$LastId = 0;
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
				$LastId = $Data->getId();
			}
		}
		$Table = new TableManger("OptionValues");
		$Insert = new InsertStatment($LastId + 1);
		$Insert->Attach($Info->getPCOId());
		$Insert->Attach($Info->getProductId());
		$Insert->Attach($Info->getValues());
		$Insert->Attach(date("y-m-d"));
		$Insert->Attach("");
		$Table->Insert($Insert);
		return true;
	}
	public static function Update(int $Id,OptionValues $Info) {
		$OldData = OptionValuesManger::GetById($Id);
		if(!$OldData) return false;
		$Condition = new Condition("Id", $Id);
		$Set = new SetStatment();
		if($Info->getPCOId()!=0) $Set->Attach("PCOId", $Info->getPCOId());
		else $Info->setPCOId($OldData->getPCOId());
		if($Info->getProductId()!=0) $Set->Attach("ProductId", $Info->getProductId());
		else $Info->setProductId($OldData->getProductId());
		if($Info->getValues()!="") $Set->Attach("Value", $Info->getValues());
		else $Info->setValues($OldData->getValues());
		if(!ProductCategoryOptionManger::GetById($Info->getPCOId())) return false;
		if(!ProductManger::GetById($Info->getProductId())) return false;
		$AllData = OptionValuesManger::GetAll();
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
			}
		}
		$Set->Attach("UpdatedAt", date("y-m-d"));
		$Table = new TableManger("OptionValues");
		$Table->Update($Condition, $Set);
		return true;
	}
	public static function GetAll(OptionValues $Info = null) {
		$Result = [];
		$Condition = new Condition();
		if($Info != null) {
			if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
			if ($Info->getPCOId() != 0) $Condition->Attach("PCOId", $Info->getPCOId());
			if ($Info->getProductId() != 0) $Condition->Attach("ProductId", $Info->getProductId());
			if ($Info->getValues() != "") $Condition->Attach("Value", $Info->getValues());
		}
		$Table = new TableManger("OptionValues");
		$AllData = $Table->GetAll($Condition);
		if (count($AllData) == 0) return false;
		foreach ($AllData as $Row) {
			array_push($Result, new OptionValues($Row["Id"], $Row["PCOId"], $Row["ProductId"], $Row["Value"], $Row["CreatedAt"], $Row["UpdatedAt"]));
		}
		return $Result;
	}
	public static function GetById(int $Id) {
		$AllData = OptionValuesManger::GetAll(new OptionValues($Id));
		if ($AllData == false) return false;
		return $AllData[0];
	}
	public static function Delete(OptionValues $Info) {
		if(!OptionValuesManger::GetAll($Info)) return false;
		$Condition = new Condition();
		if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
		if ($Info->getPCOId() != 0) $Condition->Attach("PCOId", $Info->getPCOId());
		if ($Info->getProductId() != 0) $Condition->Attach("ProductId", $Info->getProductId());
		if ($Info->getValues() != "") $Condition->Attach("Value", $Info->getValues());
		$Table = new TableManger("OptionValues");
		$Table->Delete($Condition);
		return true;
	}
}
