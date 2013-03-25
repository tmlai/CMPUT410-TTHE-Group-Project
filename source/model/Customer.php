<?php
/**
 * @author hieungo
 *
 */
namespace model;
class Customer {
	private $username;
	private $password;
	private $address;
	private $city;
	private $postalCode;
	private $email;
	
	public function __construct($username, $password, $address,
			$city, $postalCode, $email){
		$this->username = $username;
		$this->password = $password;
		$this->address = $address;
		$this->city = $city;
		$this->postalCode = $postalCode;
		$this->email = $email;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getAddress() {
		return $this->address;
	}

	public function setAddress($address) {
		$this->address = $address;
	}

	public function getCity() {
		return $this->city;
	}

	public function setCity($city) {
		$this->city = $city;
	}

	public function getPostalCode() {
		return $this->postalCode;
	}

	public function setPostalCode($postalCode) {
		$this->postalCode = $postalCode;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

}
