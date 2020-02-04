<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 04.02.2020
	 * Time: 6:59
	 */

	namespace App\Components\Export;

	use App\Components\Export\Exporters\CsvExporter;
	use App\Components\Storage\Storage;
	use App\Contracts\Export\ExporterContract;

	class ExportFactory
	{
		public static function makeExporterFromFormat(string $format): ?ExporterContract
		{
			switch ($format) {
				case 'csv':
					return new CsvExporter(new Storage());
			}
			return null;
		}
	}