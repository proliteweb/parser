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

		public function addUrl($url)
		{
			$urls = array_flip((array)$url);
			$urls = array_unique(array_merge($this->urls, $urls));
			dd(__METHOD__, $urls);
		}
	}