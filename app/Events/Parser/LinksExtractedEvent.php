<?php

	namespace App\Events\Parser;

	use App\Contracts\Event;

	class LinksExtractedEvent implements Event
	{
		/**
		 * @var array
		 */
		private $links;

		public function __construct(array $links)
		{
			// $links - is key value array [ (key is html of link) => $linkSrc ]
			// that, if you need another attributes from link, you can extract then by Extractor
			$this->setLinks($links);
		}

		public function getLinks(): array
		{
			return $this->links;
		}

		private function setLinks(array $links): self
		{
			$this->links = $links;
			return $this;
		}

	}