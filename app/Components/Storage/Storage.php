<?php

namespace App\Components\Storage;
class Storage
{
	private function getStoragePath()
	{
		return storage_path();
	}

	public function store(string $fileName, $content)
	{
		if (!file_exists(dirname($fileName)) && !mkdir($concurrentDirectory = dirname($fileName), 0777, true) && !is_dir($concurrentDirectory)) {
			throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
		}
		file_put_contents($fileName, $content);
	}



}