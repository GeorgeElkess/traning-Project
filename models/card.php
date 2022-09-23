<?php
include_once "dbmanger.php";
class Card
{
	private $Id = 0;
	function getId() {
		return $this->Id;
	}
	function setId($Id) {
		$this->Id = floatval($Id);
	}
	private $product_id = 0;
	function getproduct_id() {
		return $this->product_id;
	}
	function setproduct_id($product_id) {
		$this->product_id = floatval($product_id);
	}
	private $count = 0;
	function getcount() {
		return $this->count;
	}
	function setcount($count) {
		$this->count = floatval($count);
	}
	public function __construct($Id=null,$product_id=null,$count=null) {
		if($Id!=null) $this->setId($Id);
		if($product_id!=null) $this->setproduct_id($product_id);
		if($count!=null) $this->setcount($count);
	}
	public function Equals(Card $var) {
		if($this->product_id!=$var->getproduct_id()) return false;
		if($this->count!=$var->getcount()) return false;
		return true;
	}
	public function AllIsSet() {
		if($this->product_id == 0) return false;
		if($this->count == 0) return false;
		return true;
	}
}
class CardManger {
private function __construct() { }
	public static function Add(Card $Info) {
		if(!$Info->AllIsSet()) return false;
		$AllData = CardManger::GetAll();
		$LastId = 0;
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
				$LastId = $Data->getId();
			}
		}
		$Table = new TableManger("Card");
		$Insert = new InsertStatment($LastId + 1);
		$Insert->Attach($Info->getproduct_id());
		$Insert->Attach($Info->getcount());
		$Table->Insert($Insert);
		return true;
	}
	public static function Update(int $Id,Card $Info) {
		$OldData = CardManger::GetById($Id);
		if(!$OldData) return false;
		$Condition = new Condition("Id", $Id);
		$Set = new SetStatment();
		if($Info->getproduct_id()!=0) $Set->Attach("product_id", $Info->getproduct_id());
		else $Info->setproduct_id($OldData->getproduct_id());
		if($Info->getcount()!=0) $Set->Attach("count", $Info->getcount());
		else $Info->setcount($OldData->getcount());
		$AllData = CardManger::GetAll();
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
			}
		}
		$Table = new TableManger("Card");
		$Table->Update($Condition, $Set);
		return true;
	}
	public static function GetAll(Card $Info = null) {
		$Result = [];
		$Condition = new Condition();
		if($Info != null) {
			if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
			if ($Info->getproduct_id() != 0) $Condition->Attach("product_id", $Info->getproduct_id());
			if ($Info->getcount() != 0) $Condition->Attach("count", $Info->getcount());
		}
		$Table = new TableManger("Card");
		$AllData = $Table->GetAll($Condition);
		if (count($AllData) == 0) return false;
		foreach ($AllData as $Row) {
			array_push($Result, new Card($Row["Id"], $Row["product_id"], $Row["count"]));
		}
		return $Result;
	}
	public static function GetById(int $Id) {
		$AllData = CardManger::GetAll(new Card($Id));
		if ($AllData == false) return false;
		return $AllData[0];
	}
	public static function Delete(Card $Info) {
		if(!CardManger::GetAll($Info)) return false;
		$Condition = new Condition();
		if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
		if ($Info->getproduct_id() != 0) $Condition->Attach("product_id", $Info->getproduct_id());
		if ($Info->getcount() != 0) $Condition->Attach("count", $Info->getcount());
		$Table = new TableManger("Card");
		$Table->Delete($Condition);
		return true;
	}
}
