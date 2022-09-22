<?php
include_once "productcategoryoption.php";
include_once "product.php";
include_once "dbmanger.php";
class ProductCategory
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
	public function __construct($Id=null,$Name=null) {
		if($Id!=null) $this->setId($Id);
		if($Name!=null) $this->setName($Name);
	}
	public function Equals(ProductCategory $var) {
		if($this->Name!=$var->getName()) return false;
		return true;
	}
	public function AllIsSet() {
		if($this->Name == "") return false;
		return true;
	}
}
class ProductCategoryManger {
private function __construct() { }
	public static function Add(ProductCategory $Info) {
		if(!$Info->AllIsSet()) return false;
		$AllData = ProductCategoryManger::GetAll();
		$LastId = 0;
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
				$LastId = $Data->getId();
			}
		}
		$Table = new TableManger("ProductCategory");
		$Insert = new InsertStatment($LastId + 1);
		$Insert->Attach($Info->getName());
		$Table->Insert($Insert);
		return true;
	}
	public static function Update(int $Id,ProductCategory $Info) {
		$OldData = ProductCategoryManger::GetById($Id);
		if(!$OldData) return false;
		$Condition = new Condition("Id", $Id);
		$Set = new SetStatment();
		if($Info->getName()!="") $Set->Attach("Name", $Info->getName());
		else $Info->setName($OldData->getName());
		$AllData = ProductCategoryManger::GetAll();
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
			}
		}
		$Table = new TableManger("ProductCategory");
		$Table->Update($Condition, $Set);
		return true;
	}
	public static function GetAll(ProductCategory $Info = null) {
		$Result = [];
		$Condition = new Condition();
		if($Info != null) {
			if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
			if ($Info->getName() != "") $Condition->Attach("Name", $Info->getName());
		}
		$Table = new TableManger("ProductCategory");
		$AllData = $Table->GetAll($Condition);
		if (count($AllData) == 0) return false;
		foreach ($AllData as $Row) {
			array_push($Result, new ProductCategory($Row["Id"], $Row["Name"]));
		}
		return $Result;
	}
	public static function GetById(int $Id) {
		$AllData = ProductCategoryManger::GetAll(new ProductCategory($Id));
		if ($AllData == false) return false;
		return $AllData[0];
	}
	public static function Delete(ProductCategory $Info) {
		if(!ProductCategoryManger::GetAll($Info)) return false;
		$Condition = new Condition();
		if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
		if ($Info->getName() != "") $Condition->Attach("Name", $Info->getName());
		$Table = new TableManger("ProductCategory");
		$Data = new Product();
		$Data->setCategoryId($Info->getId());
		$AllData = ProductManger::GetAll($Data);
		if($AllData!=false) {
			foreach($AllData as $Data) {
				ProductManger::Delete(new Product($Data->getId()));
			}
		}
		$Data = new ProductCategoryOption();
		$Data->setCategoryId($Info->getId());
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
