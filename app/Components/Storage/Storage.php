<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 04.02.2020
	 * Time: 7:07
	 */
namespace App\Components\Storage;
	class Storage
	{
		private function getStoragePath()
		{
			return storage_path();
		}

		public function store(string $fileName, $content)
		{
			if (!file_exists(dirname($fileName))) {
				mkdir(dirname($fileName), 0777, true);
			}
			file_put_contents($fileName, $content);
		}


	}