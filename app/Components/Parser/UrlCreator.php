<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 02.02.2020
	 * Time: 22:21
	 */

	namespace App\Components\Parser;


	use App\Helpers\Str;

	class UrlCreator
	{
		private static $defaultProtocol = 'http://';

		private static $cachedDomains = [];

		private static $cachedUrlWithoutHost = [];

		public static function extractDomainFromUrl(string $url)
		{
			if (array_key_exists($url, static::$cachedDomains)) {
				return static::$cachedDomains[ $url ];
			}
			$domain = parse_url($url, PHP_URL_HOST);
			static::$cachedDomains[ $url ] = $domain;

			return $domain;
		}

		public static function getUrlPath(string $url)
		{
			if (array_key_exists($url, static::$cachedDomains)) {
				return static::$cachedUrlWithoutHost[ $url ];
			}
			$domain = parse_url($url, PHP_URL_PATH);
			static::$cachedUrlWithoutHost[ $url ] = $domain;

			return $domain;
		}

		public static function getUrlQuery($url)
		{
			return parse_url($url, PHP_URL_QUERY);
		}

		public static function isRelativeUrl($url)
		{
			return (Str::startsWith($url, '/')) && (!Str::startsWith($url, '//'));
		}

		public static function create(string $sourceUrl, string $domain)
		{
			if (self::isRelativeUrl($sourceUrl)){
				return self::addProtocol(static::extractDomainFromUrl($domain) . '/' . trim($sourceUrl, '/'));
			}

			$url = static::extractDomainFromUrl($domain)
				. '/' .
				trim(static::getUrlPath($sourceUrl), '/')
				. (($query = html_entity_decode(self::getUrlQuery($sourceUrl))) ? '?' . $query : '');
			return self::addProtocol($url);
		}

		public static function processMany(array $links, string $domain)
		{
			return array_map(function ($link) use ($domain) {
				return static::create($link, $domain);
			}, $links);
		}

		public static function addProtocol($url)
		{
			return $url = empty(parse_url($url)['scheme']) ? static::$defaultProtocol . ltrim($url, '/') : $url;
		}

		public static function isUrlHasProtocol(string $url)
		{
			return preg_match("~^(?:f|ht)tps?://~i", $url);
		}
	}