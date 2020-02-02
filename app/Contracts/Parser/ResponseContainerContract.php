<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 02.02.2020
	 * Time: 19:42
	 */

	namespace App\Contracts\Parser;


	interface ResponseContainerContract
	{
		public function setHeaders($headers);

		public function getHeaders(): string;

		public function setBody($body);

		public function getBody(): string;

		public function setResponseCode(int $status);

		public function getResponseCode(): int;
	}