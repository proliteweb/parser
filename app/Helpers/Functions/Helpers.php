<?php
	function config_path()
	{
		return PROJECT_DIR . '/config';
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
			dd($traceText, ...func_get_args());
		}

	}