<?php

	namespace App\Components\Parser;


	use App\Helpers\Str;

	class Filter
	{
		public function getLocalLinks(array $links, $domain ){
			return array_filter($links, function (string $link) use ($domain){
				$isRelative = (Str::startsWith($link, '/') && !Str::startsWith($link, '//'));
				$containsDomain = Str::startsWith($link, $domain);
				return $isRelative || $containsDomain;
			});
		}
	}