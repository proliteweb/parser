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
			return 'http://bessarabskiy-dvorik.com/';
		}

		public function handle()
		{
			$parser = new Parser($this->getUrlParse());
			$html = $parser->getUrlContent();
			$extractor = new Extractor($html);
			$images = $extractor->extractAttributesFromTags($extractor->extractImages(), ['src', 'title', 'alt']);
			$start = microtime(true);
			$event = new ImagesExtractedEvent($images);
			foreach (range(0, 10000000) as $n){
				EventManager::fire(new ImagesExtractedEvent($images));
			}
			dd(__METHOD__, microtime(true) - $start);

			$linksTag = $extractor->extractByTagName('a');
			$links = $extractor->extractAttributesFromTags($linksTag, ['href']);
			$links = array_column(array_values($links), 'href');
			$filter = new Filter();
			$links = $filter->getLocalLinks($links, $this->getUrlParse());
			dd(__METHOD__, $links);

		}
	}