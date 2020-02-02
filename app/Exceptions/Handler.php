<?php
	/**
	 * Created by PhpStorm.
	 * User: qwerty
	 * Date: 02.02.2020
	 * Time: 14:40
	 */

	namespace App\Exceptions;

	class Handler
	{
		public function __construct(\Error $error)
		{
			dd(__METHOD__, $error->getMessage(), $error);
		}
	}