<?php

	require_once "../include/form.inc.php";

	class User{

		private $usr_id;
		private $usr_firstname;
		private $usr_lastname;
		private $usr_email;
		private $usr_city;
		private $usr_password;



		/**
		 * User constructor.
		 * @param int $usr_id
		 * @param string $usr_firstname
		 * @param string $usr_lastname
		 * @param string $usr_email
		 * @param string $usr_city
		 * @param string $usr_password
		 */
		public function __construct($usr_id, $usr_firstname, $usr_lastname, $usr_email, $usr_city, $usr_password)
		{
			$this->usr_id = $usr_id;
			$this->usr_firstname = $usr_firstname;
			$this->usr_lastname = $usr_lastname;
			$this->usr_email = $usr_email;
			$this->usr_city = $usr_city;
			$this->usr_password = $usr_password;
		}



		/**
		 * @return int
		 */
		public function getUsrId()
		{
			return $this->usr_id;
		}

		/**
		 * @param int $usr_id
		 */
		public function setUsrId($usr_id)
		{
			$this->usr_id = cleanString($usr_id);
		}

		/**
		 * @return string
		 */
		public function getUsrFirstname()
		{
			return $this->usr_firstname;
		}

		/**
		 * @param string $usr_firstname
		 */
		public function setUsrFirstname($usr_firstname)
		{
			$this->usr_firstname = cleanString($usr_firstname);
		}

		/**
		 * @return string
		 */
		public function getUsrLastname()
		{
			return $this->usr_lastname;
		}

		/**
		 * @param string $usr_lastname
		 */
		public function setUsrLastname($usr_lastname)
		{
			$this->usr_lastname = cleanString($usr_lastname);
		}

		/**
		 * @return string
		 */
		public function getUsrEmail()
		{
			return $this->usr_email;
		}

		/**
		 * @param string $usr_email
		 */
		public function setUsrEmail($usr_email)
		{
			$this->usr_email = cleanString($usr_email);
		}

		/**
		 * @return string
		 */
		public function getUsrCity()
		{
			return $this->usr_city;
		}

		/**
		 * @param string $usr_city
		 */
		public function setUsrCity($usr_city)
		{
			$this->usr_city = cleanString($usr_city);
		}

		/**
		 * @return string
		 */
		public function getUsrPassword()
		{
			return $this->usr_password;
		}

		/**
		 * @param string $usr_password
		 */
		public function setUsrPassword($usr_password)
		{
			$this->usr_password = password_hash($usr_password);
		}



		public function __toString()
		{
			return "
				$this->usr_id, 
				$this->usr_firstname, 
				$this->usr_lastname,
				$this->usr_email,
				$this->usr_city,
				$this->usr_password
			";
		}

	}

?>