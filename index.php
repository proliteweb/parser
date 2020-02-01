<?php
	require "vendor/autoload.php";
	require "bootstrap/app.php";

	$options = getopt("f:hp:");
//	dd($argv);

	$imageParser = new \App\Console\Commands\ParseImagesCommand();
	$imageParser->handle();

//	dd(__METHOD__, $matches);
	unset($argv[0]);
//dd(fgets(STDIN, 1024));
//dd( filter_var('https://vk.com', FILTER_VALIDATE_URL));
	dd($options);