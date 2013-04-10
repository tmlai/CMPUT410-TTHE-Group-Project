<?php
namespace model;
class UserRatingProduct {
	private $username;
	private $cid;
	private $rating;
	
	public function __construct($username, $cid, $rating){
		$this->username = $username;
		$this->cid = $cid;
		$this->rating = $rating;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function getCid() {
		return $this->cid;
	}

	public function setCid($cid) {
		$this->cid = $cid;
	}

	public function getRating() {
		return $this->rating;
	}

	public function setRating($rating) {
		$this->rating = $rating;
	}

}