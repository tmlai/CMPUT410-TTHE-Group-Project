<?php
namespace model;
class Olap {
	private $username;
	private $cid;
	private $storeId;
	private $from;
	private $to;
	private $aggregatedCount;
	private $amounts;

	public function __construct($username, $cid, $storeId, $from, $to,
			$aggregatedCount, $amounts) {
		$this->username = $username;
		$this->cid = $cid;
		$this->storeId = $storeId;
		$this->from = $from;
		$this->to = $to;
		$this->aggregatedCount = $aggregatedCount;
		$this->amounts = $amounts;
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

	public function getStoreId() {
		return $this->storeId;
	}

	public function setStoreId($storeId) {
		$this->storeId = $storeId;
	}

	public function getFrom() {
		return $this->from;
	}

	public function setFrom($from) {
		$this->from = $from;
	}

	public function getTo() {
		return $this->to;
	}

	public function setTo($to) {
		$this->to = $to;
	}

	public function getAggregatedCount() {
		return $this->aggregatedCount;
	}

	public function setAggregatedCount($aggregatedCount) {
		$this->aggregatedCount = $aggregatedCount;
	}

	public function getAmounts() {
		return $this->amounts;
	}

	public function setAmounts($amounts) {
		$this->amounts = $amounts;
	}

}
