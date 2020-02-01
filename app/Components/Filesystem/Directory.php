<?php

	namespace App\Components\Filesystem;
	class Directory
	{

		public static function getFiles(string $path)
		{
			if (!is_dir($path)) {
				return [];
			}
			$list = self::getContent($path);
			$list = self::filterToOnlyFiles($list, $path);

			return $list;
		}

		public static function getFilesByExtension(string $path, $extensions)
		{
			$list = self::getFiles($path);

			return static::filterByExtension($list, $extensions);
		}

		public static function getContent($path): array
		{
			return self::clearListFromCurrentDirectories(scandir($path));
		}

		public static function filterByExtension(array $files, $extension)
		{
			$extensions = (array)$extension;

			return array_filter($files, function ($file) use ($extensions) {
				return in_array(self::getFileExtension($file), $extensions);
			});
		}

		private static function getFileExtension(string $file):?string
		{
			$parts = explode('.', $file);

			return array_pop($parts);
		}

		public static function filterToOnlyFiles(array $list, string $path)
		{
			return array_filter($list, function ($item) use ($path) {
				return is_file($path . DIRECTORY_SEPARATOR . $item);
			});
		}

		private static function clearListFromCurrentDirectories(array $list)
		{
			return array_filter($list, function (string $path) {
				return !in_array($path, ['.', '..']);
			});
		}
	}