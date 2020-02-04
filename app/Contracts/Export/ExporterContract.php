<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 04.02.2020
	 * Time: 7:02
	 */

	namespace App\Contracts\Export;

	interface ExporterContract
	{
		public function export(array $data, string $pathSave):string;
	}