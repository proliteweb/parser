<?php

	namespace App\Components\Parser;

	class Parser
	{

		private $userAgent;
		/**
		 * @var string
		 */
		private $url;

		private $followRedirects = true;

		public function __construct(string $url)
		{
			$this->setUrl($url);
			$this->setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0');
		}

		public function setUrl(string $url)
		{
			$this->url = $url;
		}

		public function setUserAgent(string $agent)
		{
			$this->userAgent = $agent;
		}

		public function setFollowRedirects(bool $flag)
		{
			$this->followRedirects = $flag;
		}

		public function getUrlContent()
		{
			$ch = curl_init($this->url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//	curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $this->followRedirects);
			curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
			$html = curl_exec($ch);
			curl_close($ch);

			return $html;
		}

	}