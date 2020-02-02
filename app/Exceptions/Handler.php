<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 02.02.2020
	 * Time: 14:40
	 */

	namespace App\Exceptions;

	use App\Components\Filesystem\Config;

	class Handler
	{
		public function __construct(\Error $error)
		{
			if (Config::get('app.env', 'production') !== 'local') {
				return null;
			}
			$this->printMessage($error);
		}

		private function printMessage(\Error $error)
		{
			dd($error->getMessage());
		}

		private function report(\Error $error)
		{
			// do awesome report
		}
	}