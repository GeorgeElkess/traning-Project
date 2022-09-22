<?php
include_once "orderdetails.php";
include_once "optionvalues.php";
include_once "dbmanger.php";
include_once "productcategory.php";
class Product
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
	private $Name = "";
	function getName() {
		return $this->Name;
	}
	function setName($Name) {
		$this->Name = $Name;
	}
	private $Price = 0;
	function getPrice() {
		return $this->Price;
	}
	function setPrice($Price) {
		$this->Price = floatval($Price);
	}
	private $ImagePath = "";
	function getImagePath() {
		return $this->ImagePath;
	}
	function setImagePath($ImagePath) {
		$this->ImagePath = $ImagePath;
	}
	public function __construct($Id=null,$CategoryId=null,$Name=null,$Price=null,$ImagePath=null) {
		if($Id!=null) $this->setId($Id);
		if($CategoryId!=null) $this->setCategoryId($CategoryId);
		if($Name!=null) $this->setName($Name);
		if($Price!=null) $this->setPrice($Price);
		if($ImagePath!=null) $this->setImagePath($ImagePath);
	}
	public function Equals(Product $var) {
		if($this->CategoryId!=$var->getCategoryId()) return false;
		if($this->Name!=$var->getName()) return false;
		if($this->Price!=$var->getPrice()) return false;
		if($this->ImagePath!=$var->getImagePath()) return false;
		return true;
	}
	public function AllIsSet() {
		if($this->CategoryId == 0) return false;
		if($this->Name == "") return false;
		if($this->Price == 0) return false;
		if($this->ImagePath == "") return false;
		return true;
	}
}
class ProductManger {
private function __construct() { }
	public static function Add(Product $Info) {
		if(!$Info->AllIsSet()) return false;
		if(!ProductCategoryManger::GetById($Info->getCategoryId())) return false;
		$AllData = ProductManger::GetAll();
		$LastId = 0;
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
				$LastId = $Data->getId();
			}
		}
		$TargetDir = "../images/";
		$TargetFile = $TargetDir . basename($_FILES["ImagePath"]["name"]);
		$imageFileType = strtolower(pathinfo($TargetFile, PATHINFO_EXTENSION));
		$check = getimagesize($_FILES["ImagePath"]["tmp_name"]);
		$UploadFile = true;
		if ($check !== false) {
		} else $UploadFile = false;
		if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
			$UploadFile = false;
		}
		if ($UploadFile == false) return false;
		move_uploaded_file($_FILES["ImagePath"]["tmp_name"], $TargetFile);
		$Info->setImagePath($TargetFile);
		$Table = new TableManger("Product");
		$Insert = new InsertStatment($LastId + 1);
		$Insert->Attach($Info->getCategoryId());
		$Insert->Attach($Info->getName());
		$Insert->Attach($Info->getPrice());
		$Insert->Attach($Info->getImagePath());
		$Table->Insert($Insert);
		return true;
	}
	public static function Update(int $Id,Product $Info) {
		$OldData = ProductManger::GetById($Id);
		if(!$OldData) return false;
		$Condition = new Condition("Id", $Id);
		$Set = new SetStatment();
		if($Info->getCategoryId()!=0) $Set->Attach("CategoryId", $Info->getCategoryId());
		else $Info->setCategoryId($OldData->getCategoryId());
		if($Info->getName()!="") $Set->Attach("Name", $Info->getName());
		else $Info->setName($OldData->getName());
		if($Info->getPrice()!=0) $Set->Attach("Price", $Info->getPrice());
		else $Info->setPrice($OldData->getPrice());
		if($Info->getImagePath()!="") $Set->Attach("ImagePath", $Info->getImagePath());
		else $Info->setImagePath($OldData->getImagePath());
		if(!ProductCategoryManger::GetById($Info->getCategoryId())) return false;
		$AllData = ProductManger::GetAll();
		if($AllData != false) {
			foreach ($AllData as $Data) {
				if($Info->Equals($Data)) return false;
			}
		}
		$Table = new TableManger("Product");
		$Table->Update($Condition, $Set);
		return true;
	}
	public static function GetAll(Product $Info = null) {
		$Result = [];
		$Condition = new Condition();
		if($Info != null) {
			if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
			if ($Info->getCategoryId() != 0) $Condition->Attach("CategoryId", $Info->getCategoryId());
			if ($Info->getName() != "") $Condition->Attach("Name", $Info->getName());
			if ($Info->getPrice() != 0) $Condition->Attach("Price", $Info->getPrice());
			if ($Info->getImagePath() != "") $Condition->Attach("ImagePath", $Info->getImagePath());
		}
		$Table = new TableManger("Product");
		$AllData = $Table->GetAll($Condition);
		if (count($AllData) == 0) return false;
		foreach ($AllData as $Row) {
			array_push($Result, new Product($Row["Id"], $Row["CategoryId"], $Row["Name"], $Row["Price"], $Row["ImagePath"]));
		}
		return $Result;
	}
	public static function GetById(int $Id) {
		$AllData = ProductManger::GetAll(new Product($Id));
		if ($AllData == false) return false;
		return $AllData[0];
	}
	public static function Delete(Product $Info) {
		if(!ProductManger::GetAll($Info)) return false;
		$Condition = new Condition();
		if ($Info->getId() != 0) $Condition->Attach("Id", $Info->getId());
		if ($Info->getCategoryId() != 0) $Condition->Attach("CategoryId", $Info->getCategoryId());
		if ($Info->getName() != "") $Condition->Attach("Name", $Info->getName());
		if ($Info->getPrice() != 0) $Condition->Attach("Price", $Info->getPrice());
		if ($Info->getImagePath() != "") $Condition->Attach("ImagePath", $Info->getImagePath());
		$Table = new TableManger("Product");
		$Data = new OptionValues();
		$Data->setProductId($Info->getId());
		$AllData = OptionValuesManger::GetAll($Data);
		if($AllData!=false) {
			foreach($AllData as $Data) {
				OptionValuesManger::Delete(new OptionValues($Data->getId()));
			}
		}
		$Data = new OrderDetails();
		$Data->setProductId($Info->getId());
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
