<?php
include_once "optionvalues.php";
include_once "dbmanger.php";
include_once "productcategory.php";
include_once "options.php";
class ProductCategoryOption
{
	private $Id = 0;
	function getId() {
		return $this->Id;
	}
	function setId($Id) {
		$this->Id = floatval($Id);
	}
	private $CategoryId = 0;
	function getCategoryId() {
		return $this->CategoryId;
	}
	function setCategoryId($CategoryId) {
		$this->CategoryId = floatval($CategoryId);
	}
	private $OptionId = 0;
	function getOptionId() {
		return $this->OptionId;
	}
	function setOptionId($OptionId) {
		$this->OptionId = floatval($OptionId);
	}
	public function __construct($Id=null,$CategoryId=null,$OptionId=null) {
		if($Id!=null) $this->setId($Id);
		if($CategoryId!=null) $this->setCategoryId($CategoryId);
		if($OptionId!=null) $this->setOptionId($OptionId);
	}
	public function Equals(ProductCategoryOption $var) {
		if($this->CategoryId!=$var->getCategoryId()) return false;
		if($this->OptionId!=$var->getOptionId()) return false;
		return true;
	}
	public function AllIsSet() {
		if($this->CategoryId == 0) return false;
		if($this->OptionId == 0) return false;
		return true;
	}
}
class ProductCategoryOptionManger {
private function __construct() { }
	public static function Add(ProductCategoryOption $Info) {
		if(!$Info->AllIsSet()) return false;
		if(!ProductCategoryManger::GetById($Info->getCategoryId())) return false;
		if(!OptionsManger::GetById($Info->getOptionId())) return false;
		$AllData = ProductCategoryOptionManger::GetAll();
		$LastId = 0;
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
				$LastId = $Data->getId();
			}
		}
		$Table = new TableManger("ProductCategoryOption");
		$Insert = new InsertStatment($LastId + 1);
		$Insert->Attach($Info->getCategoryId());
		$Insert->Attach($Info->getOptionId());
		$Table->Insert($Insert);
		return true;
	}
	public static function Update(int $Id,ProductCategoryOption $Info) {
		$OldData = ProductCategoryOptionManger::GetById($Id);
		if(!$OldData) return false;
		$Condition = new Condition("Id", $Id);
		$Set = new SetStatment();
		if($Info->getCategoryId()!=0) $Set->Attach("CategoryId", $Info->getCategoryId());
		else $Info->setCategoryId($OldData->getCategoryId());
		if($Info->getOptionId()!=0) $Set->Attach("OptionId", $Info->getOptionId());
		else $Info->setOptionId($OldData->getOptionId());
		if(!ProductCategoryManger::GetById($Info->getCategoryId())) return false;
		if(!OptionsManger::GetById($Info->getOptionId())) return false;
		$AllData = ProductCategoryOptionManger::GetAll();
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
			}
		}
		$Table = new TableManger("ProductCategoryOption");
		$Table->Update($Condition, $Set);
		return true;
	}
	public static function GetAll(ProductCategoryOption $Info = null) {
		$Result = [];
		$Condition = new Condition();
		if($Info != null) {
			if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
			if ($Info->getCategoryId() != 0) $Condition->Attach("CategoryId", $Info->getCategoryId());
			if ($Info->getOptionId() != 0) $Condition->Attach("OptionId", $Info->getOptionId());
		}
		$Table = new TableManger("ProductCategoryOption");
		$AllData = $Table->GetAll($Condition);
		if (count($AllData) == 0) return false;
		foreach ($AllData as $Row) {
			array_push($Result, new ProductCategoryOption($Row["Id"], $Row["CategoryId"], $Row["OptionId"]));
		}
		return $Result;
	}
	public static function GetById(int $Id) {
		$AllData = ProductCategoryOptionManger::GetAll(new ProductCategoryOption($Id));
		if ($AllData == false) return false;
		return $AllData[0];
	}
	public static function Delete(ProductCategoryOption $Info) {
		if(!ProductCategoryOptionManger::GetAll($Info)) return false;
		$Condition = new Condition();
		if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
		if ($Info->getCategoryId() != 0) $Condition->Attach("CategoryId", $Info->getCategoryId());
		if ($Info->getOptionId() != 0) $Condition->Attach("OptionId", $Info->getOptionId());
		$Table = new TableManger("ProductCategoryOption");
		$Data = new OptionValues();
		$Data->setPCOId($Info->getId());
		$AllData = OptionValuesManger::GetAll($Data);
		if($AllData!=false) {
			foreach($AllData as $Data) {
				OptionValuesManger::Delete(new OptionValues($Data->getId()));
			}
		}
		$Table->Delete($Condition);
		return true;
	}
}
