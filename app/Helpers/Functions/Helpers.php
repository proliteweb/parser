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

	if (!function_exists('d')) {
		function d()
		{
			$backtrace = debug_backtrace();
			$trace = array_shift($backtrace);
			$prevTrace = array_shift($backtrace);
			$methodName = \App\Helpers\Arr::get($prevTrace, 'function');
			$traceText = \App\Helpers\Arr::get($trace, 'file') . ' ' . $methodName . ' ' . \App\Helpers\Arr::get($trace, 'line');
			dd($traceText, ...func_get_args());
		}

	}