<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 01.02.2020
	 * Time: 23:27
	 */

	namespace App\Helpers;


	class Str
	{
		public static function replaceFirst($search, $replace, $subject)
		{
			if ($search == '') {
				return $subject;
			}

			$position = strpos($subject, $search);

			if ($position !== false) {
				return substr_replace($subject, $replace, $position, strlen($search));
			}

			return $subject;
		}

		public static function startsWith($haystack, $needles)
		{
			foreach ((array) $needles as $needle) {
				if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
					return true;
				}
			}

			return false;
		}

		public static function endsWith($haystack, $needles)
		{
			foreach ((array) $needles as $needle) {
				if (substr($haystack, -strlen($needle)) === (string) $needle) {
					return true;
				}
			}

			return false;
		}

		public static function contains($haystack, $needles)
		{
			foreach ((array) $needles as $needle) {
				if ($needle !== '' && mb_strpos($haystack, $needle) !== false) {
					return true;
				}
			}

			return false;
		}
	}