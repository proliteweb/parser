<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 02.02.2020
	 * Time: 20:46
	 */

	namespace App\Components\Parser;


	class UrlManager
	{
		private $urls = [];

		private $proceededUrls = [];

		private $unProceededUrls = [];

		public function addUrlList($url): self
		{
			$urls = array_flip((array)$url);
			$this->urls = (array_merge($this->urls, $urls));
			return $this;
		}

		public function addProceededUrl(string $url): self
		{
			$this->proceededUrls[ $url ] = $url;
			$this->removeUnProceededUrl($url);
			return $this;
		}

		public function isUrlProceeded(string $url)
		{
			return array_key_exists($url, $this->proceededUrls);
		}

		public function getProceededUrls(): array
		{
			return $this->proceededUrls;
		}

		public function getUnProceededUrls(): array
		{
			return $this->unProceededUrls;
		}

		public function removeUnProceededUrl(string $url)
		{
			if (array_key_exists($url, $this->unProceededUrls)) {
				unset($this->unProceededUrls[ $url ]);
			}
		}

		public function addUnProceededUrls( $unProceededUrls)
		{
			foreach ((array)$unProceededUrls as $unProceededUrl) {
				if ($this->isUrlProceeded($unProceededUrl)) {
					continue;
				}
				$this->unProceededUrls[ $unProceededUrl ] = $unProceededUrl;
			}
		}

		public function getUnProceededUrl():?string
		{
			$url = ($urls = $this->getUnProceededUrls()) ? reset($urls) : null;
			return $url;
		}
	}