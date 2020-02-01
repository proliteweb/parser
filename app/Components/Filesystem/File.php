<?php
/**
 * Created by PhpStorm.
 * User: qwerty
 * Date: 01.02.2020
 * Time: 12:42
 */

namespace App\Components\Filesystem;
class File {

	public static function fileNameWithoutExt(string $fileName){
		$parts = explode('.', $fileName);
		array_pop($parts);
		return implode('.', $parts);
	}
}