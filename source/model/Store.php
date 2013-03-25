<?php
namespace model;
/**
 * @author hieungo
 *
 */
class Store {
	private $storeId;
	private $description;
	private $name;
	private $url;
	
	public function __construct($storeId, $description, $name, $url){
		$this->storeId = $storeId;
		$this->description = $description;
		$this->name = $name;
		$this->url = $url;
	}

	public function getStoreId() {
		return $this->storeId;
	}

	public function setStoreId($storeId) {
		$this->storeId = $storeId;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getUrl() {
		return $this->url;
	}

	public function setUrl($url) {
		$this->url = $url;
	}

}
?>