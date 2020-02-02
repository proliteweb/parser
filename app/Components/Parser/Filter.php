<?php

	namespace App\Components\Parser;

	use App\Helpers\Str;

	class Filter
	{
		private $filterUnique = false;

		public function setFilterUnique(bool $flag)
		{
			$this->filterUnique = $flag;
		}

		public function isFilterUnique(): bool
		{
			return $this->filterUnique;
		}


		public function getRelateLinks(array $links, $domain)
		{
			$links = array_filter($links, function (string $link) use ($domain) {
				$isRelative = (Str::startsWith($link, '/') && !Str::startsWith($link, '//'));
				$containsDomain = Str::startsWith($link, $domain);
				return $isRelative || $containsDomain;
			});

			if ($this->isFilterUnique()){
				$links = array_unique($links);
			}
			return $links;
		}
	}