<?php

//	require_once("../include/form.inc.php");

	class Category {

		private $cat_id;
		private $cat_name;


		/**
		 * Category constructor.
		 * @param int $cat_id
		 * @param string $cat_name
		 */

		public function __construct($cat_id, $cat_name)
		{
			$this->cat_id = $cat_id;
			$this->cat_name = $cat_name;
		}



		/**
		 * @return int
		 */
		public function getCatId()
		{
			return $this->cat_id;
		}

		/**
		 * @param int $cat_id
		 */
		public function setCatId($cat_id)
		{
			$this->cat_id = cleanString($cat_id);
		}

		/**
		 * @return string
		 */
		public function getCatName()
		{
			return $this->cat_name;
		}

		/**
		 * @param string $cat_name
		 */
		public function setCatName($cat_name)
		{
			$this->cat_name = cleanString($cat_name);
		}

		public function __toString()
		{

			return "
				$this->cat_id,
				$this->cat_name
			";

		}

	}


?>