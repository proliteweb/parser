<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 03.02.2020
	 * Time: 21:12
	 */

	namespace App\Components\Parser;


	class ImagesContainer
	{
		private $images = [];

		public function addImages(array $images): self
		{
			foreach ($images as $image) {
				$this->addImage($image);
			}
			return $this;
		}

		public function addImage(string $image): self
		{
			$this->images[ $image ] = $image;
			return $this;
		}

		public function hasImage(string $image): bool
		{
			return array_key_exists($image, $this->images);
		}

		public function getImages(): array
		{
			return $this->images;
		}

	}