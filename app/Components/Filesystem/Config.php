<?php

namespace App\Components\Filesystem;

use App\Helpers\Arr;

class Config
{

	private static $initialized = false;
	private static $config = [];

	public static function get(string $key, $default = null)
	{
		if (!static::$initialized) {
			static::init();
		}

//		dd(__METHOD__, static::$config, $key);
		return Arr::get(static::$config, $key, $default);
	}

	private static function init(): void
	{
		static::$initialized = true;
		$files = Directory::getFilesByExtension(config_path(), 'php');
		foreach ($files as $file) {
			$key = File::fileNameWithoutExt($file);
			$config = [];
			try {
				$configArr = include config_path() . DIRECTORY_SEPARATOR . $file;
				if (is_array($configArr)) {
					$config = $configArr;
				}
			} catch (\Exception $e) {
			}
			static::$config[$key] = $config;
		}
	}
}