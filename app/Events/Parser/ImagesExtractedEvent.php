<?php

	namespace App\Events\Parser;

	use App\Contracts\Event;

	class ImagesExtractedEvent implements Event
	{
		/**
		 * @var array
		 */
		private $images;

		public function __construct(array $images)
		{
			// $images - is html, not extracted tags
			$this->setImages($images);
		}

		public function getImages(): array
		{
			return $this->images;
		}

		private function setImages(array $images): self
		{
			$this->images = $images;
			return $this;
		}

	}