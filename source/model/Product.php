<?php
/**
 * @author hieungo
 *
 */
namespace model;
class Product {
	private $cid;
	private $name;
	private $description;
	private $image;
	private $price;
	private $weight;
	private $dimensions;
	private $stock;
	
	public function __construct($cid, $name, $description, $image,
			$price, $weight, $dimensions, $stock){
		$this->cid = $cid;
		$this->name = $name;
		$this->description = $description;
		$this->image = $image;
		$this->price = $price;
		$this->weight = $weight;
		$this->dimensions = $dimensions;
		$this->stock = $stock;
	}

	public function getCid() {
		return $this->cid;
	}

	public function setCid($cid) {
		$this->cid = $cid;
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

	public function getImage() {
		return $this->image;
	}

	public function setImage($image) {
		$this->image = $image;
	}

	public function getPrice() {
		return $this->price;
	}

	public function setPrice($price) {
		$this->price = $price;
	}

	public function getWeight() {
		return $this->weight;
	}

	public function setWeight($weight) {
		$this->weight = $weight;
	}

	public function getDimensions() {
		return $this->dimensions;
	}

	public function setDimensions($dimensions) {
		$this->dimensions = $dimensions;
	}

	public function getStock() {
		return $this->stock;
	}

	public function setStock($stock) {
		$this->stock = $stock;
	}

}
