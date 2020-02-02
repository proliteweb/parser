<?php

	namespace App\Console\Commands;

	use App\Components\Events\EventManager;
	use App\Components\Parser\Extractor;
	use App\Components\Parser\Filter;
	use App\Components\Parser\Parser;
	use App\Console\Console;
	use App\Events\Parser\ImagesExtractedEvent;


	class ParseImagesCommand extends Console
	{
		private function getUrlParse(){
			//todo - change to $this->getParameter('url');
			return 'citrus.ua';
		}

		public function handle()
		{
			$parser = new Parser($this->getUrlParse());
			$html = $parser->getUrlContent();
			$extractor = new Extractor($html);
			$images = $extractor->extractAttributesFromTags($extractor->extractImages(), ['src', 'title', 'alt']);

			EventManager::fire(new ImagesExtractedEvent($images));

			$linksTag = $extractor->extractByTagName('a');
			$links = $extractor->extractAttributesFromTags($linksTag, ['href']);
			$links = array_column(array_values($links), 'href');
			$filter = new Filter();
			$links = $filter->getLocalLinks($links, $this->getUrlParse());
			dd(__METHOD__, $links);

		}
	}