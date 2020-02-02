<?php
	function config_path()
	{
		return PROJECT_DIR . '/config';
	}

	if (!function_exists('classImplementsInterface')) {
		function classImplementsInterface($class, $interface): bool
		{
			$interfaces = class_implements($class);
			return \App\Helpers\Arr::has($interfaces, $interface);
		}
	}