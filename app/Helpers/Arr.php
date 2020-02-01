<?php

namespace App\Helpers;

class Arr {

	public static function dot($array, $prepend = '') {
		$dotted = [];
		foreach( $array as $key => $value ) {
			if ( is_array($value) && ! empty($value) ) {
				$dotted = array_merge($dotted, static::dot($value, $prepend . $key . '.'));
				continue;
			}
			$dotted[ $prepend . $key ] = $value;
		}

		return $dotted;
	}

	public static function get($array, $key, $default = null)
	{
		if (is_null($key)) {
			return $array;
		}

		if (static::exists($array, $key)) {
			return $array[$key];
		}

		if (strpos($key, '.') === false) {
			return $array[$key] ?? $default;
		}

		foreach (explode('.', $key) as $segment) {
			if (static::accessible($array) && static::exists($array, $segment)) {
				$array = $array[$segment];
			} else {
				return $default;
			}
		}

		return $array;
	}

	public static function exists($array, $key) {
		return array_key_exists($key, $array);
	}

	public static function accessible($value)
	{
		return is_array($value) || $value instanceof ArrayAccess;
	}


}