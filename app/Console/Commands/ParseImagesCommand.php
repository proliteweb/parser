<?php

	namespace App\Console\Commands;

	use App\Components\Events\EventManager;
	use App\Components\Export\ExportFactory;
	use App\Components\Filesystem\Config;
	use App\Components\Parser\Extractor;
	use App\Components\Parser\Filter;
	use App\Components\Parser\ImagesContainer;
	use App\Components\Parser\Parser;
	use App\Components\Parser\UrlCreator;
	use App\Components\Parser\UrlManager;
	use App\Console\Console;
	use App\Contracts\ResponseCodes;
	use App\Events\Parser\ImagesSingleUrlExtractedEvent;
	use App\Events\Parser\LinksSingleUrlExtractedEvent;


	class ParseImagesCommand extends Console
	{
		private $limitParse = 10000;
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
			$limitUrls = (int)Config::get('parser.limit_iterations', $this->limitParse);
			$this->parse($this->getUrlParse());
			while ($this->getUrlManager()->getUnProceededUrls() && $limitUrls) {
				$limitUrls--;
				$this->parse($this->getUrlManager()->getUnProceededUrl());
			}
			if ($path = $this->storeImages($this->getImagesContainer())){
				echo 'Images stored to: ' . $path;
			}
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

		private function storeImages(ImagesContainer $imagesContainer):?string
		{
			if ($images = $imagesContainer->getImages()) {
				$format = 'csv';
				$exporter = ExportFactory::makeExporterFromFormat($format);
				if ($exporter) {
					$pathSave = 'exports/' . UrlCreator::extractDomainFromUrl($this->getUrlParse()) . '-' . date('Y-m-d-H-i-s');
					$pathSave = $exporter->export($images, $pathSave);
					return $pathSave;
				}
			}
			return null;
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
			EventManager::fire(new ImagesSingleUrlExtractedEvent($images, $url));
		}

		private function onLinksExtracted(array $links, $url)
		{
			EventManager::fire(new LinksSingleUrlExtractedEvent($links, $url));
		}

		private function getImagesContainer(): ImagesContainer
		{
			return $this->imagesContainer;
		}

		private function getUrlParse()
		{
			//todo - change to $this->getInputParameter('url');
			return UrlCreator::addProtocol('bessarabskiy-dvorik.com/menu/holodnye-zakuski');
		}
	}