<?php

	namespace App\Console\Commands;

	use App\Components\Events\EventManager;
	use App\Components\Parser\Extractor;
	use App\Components\Parser\Filter;
	use App\Components\Parser\ImagesContainer;
	use App\Components\Parser\Parser;
	use App\Components\Parser\UrlCreator;
	use App\Components\Parser\UrlManager;
	use App\Console\Console;
	use App\Contracts\ResponseCodes;
	use App\Events\Parser\ImagesExtractedEvent;
	use App\Events\Parser\LinksExtractedEvent;


	class ParseImagesCommand extends Console
	{
		/** @var UrlManager */
		private $urlManager;

		/** @var Extractor */
		private $extractor;

		/** @var Filter */
		private $filter;

		/** @var Parser */
		private $parser;

		//todo temporary for dev - move this to ImageManager
		private $imagesContainer;

		public function __construct()
		{
			//If we have'd Service Container, of course we get this manager in constructor, but have what we have
			$this->urlManager = new UrlManager();
			$this->extractor = new Extractor();
			$this->filter = new Filter();
			$this->parser = new Parser($this->getUrlParse());
			$this->imagesContainer = new ImagesContainer();

			$this->setDefaults();
		}

		public function handle()
		{
			$limitUrls = 20;
			$this->parse($this->getUrlParse());
			while ($this->getUrlManager()->getUnProceededUrls() && $limitUrls) {
				$limitUrls--;
				$this->parse($this->getUrlManager()->getUnProceededUrl());
			}
			d($this->getImagesContainer(), $this->getUrlManager());
		}

		private function parse($url)
		{
			$domain = UrlCreator::addProtocol(UrlCreator::extractDomainFromUrl($url));
			$url = UrlCreator::addProtocol($url);
			($parser = $this->getParser())->setUrl($url);
			$responseContainer = $parser->getUrlContent();
			if (ResponseCodes::HTTP_OK !== $responseContainer->getResponseCode()) {
				return null;
			}
			($extractor = $this->getExtractor())->setHtml($responseContainer->getBody());
			$images = $extractor->extractAttributeFromTags($extractor->extractImages(), 'src');
			$this->getImagesContainer()->addImages($images);

			$this->onImagesExtracted($images, $url);

			$linksTag = $extractor->extractTagByName('a');
			$links = $extractor->extractAttributeFromTags($linksTag, 'href');

			$this->onLinksExtracted($links, $url);

			$localLinks = $this->getFilter()->getRelateLinks($links, $domain);

			$localLinks = UrlCreator::processMany($localLinks, $url);
			$this->getUrlManager()->addProceededUrl($url)->addUrlList($localLinks)->addUnProceededUrls($localLinks);

		}


		private function setDefaults()
		{
			$this->filter->setFilterUnique(true);
		}

		private function getParser(): Parser
		{
			return $this->parser;
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

		private function onImagesExtracted(array $images, $url)
		{
			EventManager::fire(new ImagesExtractedEvent($images, $url));
		}

		private function onLinksExtracted(array $links, $url)
		{
			EventManager::fire(new LinksExtractedEvent($links, $url));
		}

		private function getImagesContainer(): ImagesContainer
		{
			return $this->imagesContainer;
		}

		private function getUrlParse()
		{
			//todo - change to $this->getInputParameter('url');
			return UrlCreator::addProtocol('https://www.mastervelo.com');
		}


	}