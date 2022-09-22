<?php
include_once "dbmanger.php";
include_once "orders.php";
include_once "product.php";
class OrderDetails
{
	private $Id = 0;
	function getId() {
		return $this->Id;
	}
	function setId($Id) {
		$this->Id = floatval($Id);
	}
	private $OrderId = 0;
	function getOrderId() {
		return $this->OrderId;
	}
	function setOrderId($OrderId) {
		$this->OrderId = floatval($OrderId);
	}
	private $ProductId = 0;
	function getProductId() {
		return $this->ProductId;
	}
	function setProductId($ProductId) {
		$this->ProductId = floatval($ProductId);
	}
	private $CurrentPrice = 0;
	function getCurrentPrice() {
		return $this->CurrentPrice;
	}
	function setCurrentPrice($CurrentPrice) {
		$this->CurrentPrice = floatval($CurrentPrice);
	}
	private $Number = 0;
	function getNumber() {
		return $this->Number;
	}
	function setNumber($Number) {
		$this->Number = floatval($Number);
	}
	public function __construct($Id=null,$OrderId=null,$ProductId=null,$CurrentPrice=null,$Number=null,$CreatedAt=null,$UpdatedAt=null) {
		if($Id!=null) $this->setId($Id);
		if($OrderId!=null) $this->setOrderId($OrderId);
		if($ProductId!=null) $this->setProductId($ProductId);
		if($CurrentPrice!=null) $this->setCurrentPrice($CurrentPrice);
		if($Number!=null) $this->setNumber($Number);
		if ($CreatedAt != null) $this->setCreatedAt($CreatedAt);
		if ($UpdatedAt != null) $this->setUpdatedAt($UpdatedAt);
	}
	public function Equals(OrderDetails $var) {
		if($this->OrderId!=$var->getOrderId()) return false;
		if($this->ProductId!=$var->getProductId()) return false;
		if($this->CurrentPrice!=$var->getCurrentPrice()) return false;
		if($this->Number!=$var->getNumber()) return false;
		return true;
	}
	public function AllIsSet() {
		if($this->OrderId == 0) return false;
		if($this->ProductId == 0) return false;
		if($this->CurrentPrice == 0) return false;
		if($this->Number == 0) return false;
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
class OrderDetailsManger {
private function __construct() { }
	public static function Add(OrderDetails $Info) {
		if(!$Info->AllIsSet()) return false;
		if(!OrdersManger::GetById($Info->getOrderId())) return false;
		if(!ProductManger::GetById($Info->getProductId())) return false;
		$AllData = OrderDetailsManger::GetAll();
		$LastId = 0;
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
				$LastId = $Data->getId();
			}
		}
		$Table = new TableManger("OrderDetails");
		$Insert = new InsertStatment($LastId + 1);
		$Insert->Attach($Info->getOrderId());
		$Insert->Attach($Info->getProductId());
		$Insert->Attach($Info->getCurrentPrice());
		$Insert->Attach($Info->getNumber());
		date_default_timezone_set("Egypt/Cairo");
		$Insert->Attach(date("y-m-d"));
		$Table->Insert($Insert);
		return true;
	}
	public static function Update(int $Id,OrderDetails $Info) {
		$OldData = OrderDetailsManger::GetById($Id);
		if(!$OldData) return false;
		$Condition = new Condition("Id", $Id);
		$Set = new SetStatment();
		if($Info->getOrderId()!=0) $Set->Attach("OrderId", $Info->getOrderId());
		else $Info->setOrderId($OldData->getOrderId());
		if($Info->getProductId()!=0) $Set->Attach("ProductId", $Info->getProductId());
		else $Info->setProductId($OldData->getProductId());
		if($Info->getCurrentPrice()!=0) $Set->Attach("CurrentPrice", $Info->getCurrentPrice());
		else $Info->setCurrentPrice($OldData->getCurrentPrice());
		if($Info->getNumber()!=0) $Set->Attach("Number", $Info->getNumber());
		else $Info->setNumber($OldData->getNumber());
		if(!OrdersManger::GetById($Info->getOrderId())) return false;
		if(!ProductManger::GetById($Info->getProductId())) return false;
		$AllData = OrderDetailsManger::GetAll();
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
			}
		}
		date_default_timezone_set("Egypt/Cairo");
		$Set->Attach("UpdatedAt", date("y-m-d"));
		$Table = new TableManger("OrderDetails");
		$Table->Update($Condition, $Set);
		return true;
	}
	public static function GetAll(OrderDetails $Info = null) {
		$Result = [];
		$Condition = new Condition();
		if($Info != null) {
			if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
			if ($Info->getOrderId() != 0) $Condition->Attach("OrderId", $Info->getOrderId());
			if ($Info->getProductId() != 0) $Condition->Attach("ProductId", $Info->getProductId());
			if ($Info->getCurrentPrice() != 0) $Condition->Attach("CurrentPrice", $Info->getCurrentPrice());
			if ($Info->getNumber() != 0) $Condition->Attach("Number", $Info->getNumber());
		}
		$Table = new TableManger("OrderDetails");
		$AllData = $Table->GetAll($Condition);
		if (count($AllData) == 0) return false;
		foreach ($AllData as $Row) {
			array_push($Result, new OrderDetails($Row["Id"], $Row["OrderId"], $Row["ProductId"], $Row["CurrentPrice"], $Row["Number"], $Row["CreatedAt"], $Row["UpdatedAt"]));
		}
		return $Result;
	}
	public static function GetById(int $Id) {
		$AllData = OrderDetailsManger::GetAll(new OrderDetails($Id));
		if ($AllData == false) return false;
		return $AllData[0];
	}
	public static function Delete(OrderDetails $Info) {
		if(!OrderDetailsManger::GetAll($Info)) return false;
		$Condition = new Condition();
		if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
		if ($Info->getOrderId() != 0) $Condition->Attach("OrderId", $Info->getOrderId());
		if ($Info->getProductId() != 0) $Condition->Attach("ProductId", $Info->getProductId());
		if ($Info->getCurrentPrice() != 0) $Condition->Attach("CurrentPrice", $Info->getCurrentPrice());
		if ($Info->getNumber() != 0) $Condition->Attach("Number", $Info->getNumber());
		$Table = new TableManger("OrderDetails");
		$Table->Delete($Condition);
		return true;
	}
}
