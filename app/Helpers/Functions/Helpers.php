<?php

	function project_path($path = null)
	{
		return PROJECT_DIR . (($path) ? DIRECTORY_SEPARATOR . ltrim($path, '/') : '');
	}

	function config_path()
	{
		return project_path('/config');
	}

	function storage_path($path = null)
	{
		return project_path('storage' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . ltrim($path, '/'));
	}

	if (!function_exists('classImplementsInterface')) {
		function classImplementsInterface($class, $interface): bool
		{
			$interfaces = class_implements($class);
			return in_array($interface, $interfaces);
		}
	}

	if (!function_exists('d')) {
		function d()
		{
			$backtrace = debug_backtrace();
			$trace = array_shift($backtrace);
			$prevTrace = array_shift($backtrace);
			$methodName = $prevTrace['function'] ?? '';
			$traceText = ($trace['file'] ?? '') . ' ' . $methodName . ' ' . ($trace['line'] ?? '');
			var_dump($traceText, ...func_get_args());
		}

	}