<?php
namespace model;
class Category implements JsonSerializable {
	private $cateId;
	private $name;
	private $description;
	
	public function jsonSerialize() {
		$array = array();
		$array['cateId'] = $this->cateId;
		$array['name'] = $this->name;
		$array['description'] = $this->description;
		return $array;
	}

	/*
	 * $cateId can be random number for inserting the object into table.
	 */
	public function __construct($cateId, $name, $desc) {
		$this->cateId = $cateId;
		$this->name = $name;
		$this->description = $desc;
	}

	public function getCateId() {
		return $this->cateId;
	}

	public function setCateId($cateId) {
		$this->cateId = $cateId;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}
}
