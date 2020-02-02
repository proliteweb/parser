<?php

	namespace App\Console\Commands;

	use App\Components\Events\EventManager;
	use App\Components\Parser\Extractor;
	use App\Components\Parser\Filter;
	use App\Components\Parser\Parser;
	use App\Components\Parser\UrlManager;
	use App\Console\Console;
	use App\Contracts\ResponseCodes;
	use App\Events\Parser\ImagesExtractedEvent;


	class ParseImagesCommand extends Console
	{
		/** @var UrlManager */
		private $urlManager;

		/** @var Extractor */
		private $extractor;

		/** @var Filter */
		private $filter;

		public function __construct()
		{
			//If we have'd Service Container, of course we get this manager in constructor, but have what we have
			$this->urlManager = new UrlManager();
			$this->extractor = new Extractor();
			$this->filter = new Filter();

			$this->setDefaults();
		}

		public function handle()
		{
			$parser = new Parser($this->getUrlParse());
			$responseContainer = $parser->getUrlContent();
			if (ResponseCodes::HTTP_OK !== $responseContainer->getResponseCode()) {
				return null;
			}
			($extractor = $this->getExtractor())->setHtml($responseContainer->getBody());
			$images = $extractor->extractAttributeFromTags($extractor->extractImages(), 'src');

			EventManager::fire(new ImagesExtractedEvent($images));

			$linksTag = $extractor->extractByTagName('a');
			$links = $extractor->extractAttributeFromTags($linksTag, 'href');
			$filter = $this->getFilter();
			$localLinks = $filter->getLocalLinks($links, $this->getUrlParse());
			dd(__METHOD__, $localLinks);
			$this->urlManager->addUrl($localLinks);
			dd(__METHOD__, $links);
		}


		private function setDefaults()
		{
			$this->filter->setFilterUnique(true);
		}

		private function getExtractor(): Extractor
		{
			return $this->extractor;
		}

		private function getUrlManager(): UrlManager
		{
			return $this->urlManager;
		}

		private function getFilter(): Filter
		{
			return $this->filter;
		}

		private function getUrlParse()
		{
			//todo - change to $this->getParameter('url');
			return 'http://bessarabskiy-dvorik.com/';
		}


	}