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
		public function handle(\Throwable $error){
			if (Config::get('app.env', 'production') !== 'local') {
				return null;
			}
			$this->printMessage($error);
		}

		private function printMessage(\Throwable $error)
		{
//			echo '<pre>';
			d($error);
		}

		private function report(\Throwable $error)
		{
			// do awesome report
		}
	}