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
	private $rating;

	private $totalSold;

	public function json_encode() {
		$array = array();
		$array['cid'] = $this->cid;
		$array['name'] = $this->name;
		$array['description'] = $this->description;
		$array['image'] = $this->image;
		$array['price'] = $this->price;
		$array['weight'] = $this->weight;
		$array['dimensions'] = $this->dimensions;
		$array['stock'] = $this->stock;
		$array['rating'] = $this->rating;
		$array['totalSold'] = $this->totalSold;
		return \json_encode($array);
	}
	
	public function toAssociativeArray(){
		$array = array();
		$array['cid'] = $this->cid;
		$array['name'] = $this->name;
		$array['description'] = $this->description;
		$array['image'] = $this->image;
		$array['price'] = $this->price;
		$array['weight'] = $this->weight;
		$array['dimensions'] = $this->dimensions;
		$array['stock'] = $this->stock;
		$array['rating'] = $this->rating;
		$array['totalSold'] = $this->totalSold;
		return $array;
	}

	public function __construct($cid, $name, $description, $image, $price,
			$weight, $dimensions, $stock) {
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

	public function getRating() {
		return $this->rating;
	}

	public function setRating($rating) {
		$this->rating = $rating;
	}

	public function getTotalSold() {
		return $this->totalSold;
	}

	public function setTotalSold($totalSold) {
		$this->totalSold = $totalSold;
	}

}
?>