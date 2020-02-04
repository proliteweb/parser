<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 04.02.2020
	 * Time: 7:01
	 */

	namespace App\Components\Export\Exporters;


	use App\Components\Storage\Storage;
	use App\Contracts\Export\ExporterContract;

	class CsvExporter implements ExporterContract
	{
		protected $ext = 'csv';
		/**
		 * @var Storage
		 */
		private $storage;

		public function __construct(Storage $storage)
		{
			$this->storage = $storage;
		}

		private function getStorage(): Storage
		{
			return $this->storage;
		}

		private function addExtension(string $fileName)
		{
			return $fileName . '.' . $this->ext;
		}

		private function addStoragePath(string $path)
		{
			return storage_path($path);
		}

		public function export(array $data, string $pathSave): string
		{
			$fileName = $this->addStoragePath($this->addExtension($pathSave));
			$this->getStorage()->store($fileName, '');

			$fp = fopen($fileName, 'w');


			foreach ($data as $fields) {
				fputcsv($fp, (array)$fields);
			}

			fclose($fp);
			return (string)$fileName;
		}
	}