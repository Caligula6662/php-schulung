<?php

	require_once ("../include/form.inc.php");
	require_once ("category.inc.php");
	require_once ("user.inc.php");


	class Blog
	{

		private $blog_id;
		private $blog_headline;
		private $blog_imagePath;
		private $blog_imageAlignment;
		private $blog_content;
		private $blog_date;
		private $category;
		private $user;


		/**
		 * Blogpost constructor.
		 *
		 * @param int $blog_id
		 * @param string $blog_headline
		 * @param string $blog_imagePath
		 * @param string $blog_imageAlignment
		 * @param string $blog_content
		 * @param date $blog_date
		 * @param Category $category
		 * @param User $user
		 */

		public function __construct(
			$blog_id,
			$blog_headline,
			$blog_imagePath,
			$blog_imageAlignment,
			$blog_content,
			$blog_date,
			$category,
			$user
		)
		{
			$this->blog_id = $blog_id;
			$this->blog_headline = $blog_headline;
			$this->blog_imagePath = $blog_imagePath;
			$this->blog_imageAlignment = $blog_imageAlignment;
			$this->blog_content = $blog_content;
			$this->blog_date = $blog_date;
			$this->category = $category;
			$this->user = $user;

		}

		/**
		 * @return int
		 */
		public function getBlogId()
		{
			return $this->blog_id;
		}

		/**
		 * @param int $blog_id
		 */
		public function setBlogId($blog_id)
		{
			$this->blog_id = cleanString($blog_id);
		}

		/**
		 * @return string
		 */
		public function getBlogHeadline()
		{
			return $this->blog_headline;
		}

		/**
		 * @param string $blog_headline
		 */
		public function setBlogHeadline($blog_headline)
		{
			$this->blog_headline = cleanString($blog_headline);
		}

		/**
		 * @return string
		 */
		public function getBlogImagePath()
		{
			return $this->blog_imagePath;
		}

		/**
		 * @param string $blog_imagePath
		 */
		public function setBlogImagePath($blog_imagePath)
		{
			$this->blog_imagePath = cleanString($blog_imagePath);
		}

		/**
		 * @return string
		 */
		public function getBlogImageAlignment()
		{
			return $this->blog_imageAlignment;
		}

		/**
		 * @param string $blog_imageAlignment
		 */
		public function setBlogImageAlignment($blog_imageAlignment)
		{
			$this->blog_imageAlignment = cleanString($blog_imageAlignment);
		}

		/**
		 * @return string
		 */
		public function getBlogContent()
		{
			return $this->blog_content;
		}

		/**
		 * @param string $blog_content
		 */
		public function setBlogContent($blog_content)
		{
			$this->blog_content = cleanString($blog_content);
		}

		/**
		 * @return date
		 */
		public function getBlogDate()
		{
			return $this->blog_date;
		}

		/**
		 * @param date $blog_date
		 */
		public function setBlogDate($blog_date)
		{
			$this->blog_date = cleanString($blog_date);
		}

		/**
		 * @return Category
		 */
		public function getCategory()
		{
			return $this->category;
		}

		/**
		 * @param Category $category
		 */
		public function setCategory($category)
		{
			if (!gettype($category) == Category) {
				$this->category = "Falsche Typisierung";
			} else {
				$this->category = $category;
			}

		}

		/**
		 * @return User
		 */
		public function getUser()
		{
			return $this->user;
		}

		/**
		 * @param User $user
		 */
		public function setUser($user)
		{
			if (!gettype($user) == User) {
				$this->user = "Falsche Typisierung";
			} else {
				$this->user = $user;
			}
		}



		function __toString() {
			return "
				$this->blog_id, 
				$this->blog_headline, 
				$this->blog_imagePath, 
				$this->blog_imageAlignment, 
				$this->blog_content, 
				$this->blog_date, 
				$this->category, 
				$this->user,
			";
		}


	}
?>