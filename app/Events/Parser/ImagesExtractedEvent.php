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
			// $images - is key value array [(key is html of image) => $imageSrc ]
			// that, if you need another attributes from image, you can extract then by Extractor
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