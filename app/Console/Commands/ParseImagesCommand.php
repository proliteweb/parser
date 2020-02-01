<?php

	namespace App\Console\Commands;

	use \App\Console\Console;

	class ParseImagesCommand extends Console
	{

		public function handle()
		{
			$parser = new \App\Components\Parser('citrus.ua');
			$html = $parser->getUrlContent();

			dd($html);

			$regex = '/<img[^>]+>/i';
			preg_match_all($regex, $html, $matches);
			$img = array();
			foreach ($matches[0] as $img_tag) {
				preg_match_all('/(src)=("[^"]*")/i', $img_tag, $img[$img_tag]);
			}
			dd(__METHOD__, array_column($img, 2));

		}
	}