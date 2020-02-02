<?php

	namespace App\Components\Parser;

	use App\Contracts\Parser\ResponseContainerContract;

	class Parser
	{

		private $userAgent;
		/**
		 * @var string
		 */
		private $url;

		private $followRedirects = true;

		public function __construct(string $url = '')
		{
			$this->setUrl($url);
			$this->setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0');
		}

		public function setUrl(string $url)
		{
			$this->url = $url;
		}

		public function getUrl()
		{
			return $this->prepareUrl($this->url);
		}

		private function prepareUrl(string $url)
		{
			return rtrim($url, '/');
		}

		public function setUserAgent(string $agent)
		{
			$this->userAgent = $agent;
		}

		public function setFollowRedirects(bool $flag)
		{
			$this->followRedirects = $flag;
		}

		public function getUrlContent(): ResponseContainerContract
		{

			$ch = curl_init($this->getUrl());
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $this->followRedirects);
			curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);

			$response = curl_exec($ch);

			$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

			curl_close($ch);

			$header = substr($response, 0, $header_size);
			$body = substr($response, $header_size);

			($responseContainer = new ResponseContainer())
				->setHeaders($header)
				->setBody($body)
				->setResponseCode((int)$status)
			;

			return $responseContainer;
		}

	}