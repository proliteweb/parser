<?php

	namespace App\Events\Parser;

	use App\Contracts\Event;

	class ImagesExtractedEvent implements Event
	{
		/**
		 * @var array
		 */
		private $images;
		/**
		 * @var
		 */
		private $url;

		public function __construct(array $images, ?string $url)
		{
			// $images - is key value array [(key is html of image) => $imageSrc ]
			// that, if you need another attributes from image, you can extract then by Extractor
			$this->setImages($images);
			$this->url = $url;
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

		public function getUrl(): ?string
		{
			return $this->url;
		}

	}