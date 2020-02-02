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
			$this->images = $images;
		}

		public function getImages(): array
		{
			return $this->images;
		}

	}