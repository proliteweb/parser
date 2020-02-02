<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 02.02.2020
	 * Time: 19:35
	 */

	namespace App\Components\Parser;


	use App\Contracts\Parser\ResponseContainerContract;

	class ResponseContainer implements ResponseContainerContract
	{
		private $headers;

		private $body;

		private $statusCode = 200;

		public function setHeaders($headers): self
		{
			$this->headers = $headers;
			return $this;
		}

		public function getHeaders(): string
		{
			return (string)$this->headers;
		}

		public function setBody($body): self
		{
			$this->body = $body;
			return $this;
		}

		public function getBody(): string
		{
			return (string)$this->body;
		}

		public function setResponseCode(int $status)
		{
			$this->statusCode = $status;
		}

		public function getResponseCode(): int
		{
			return $this->statusCode;
		}
	}