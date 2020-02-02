<?php
	require "vendor/autoload.php";
	require "bootstrap/app.php";

	$options = getopt("f:hp:");
//	dd($argv);

	try{
		$imageParser = new \App\Console\Commands\ParseImagesCommand();
		$imageParser->handle();
	} catch (Error $error){
		new \App\Exceptions\Handler($error);
	}

//	dd(__METHOD__, $matches);
	unset($argv[0]);
//dd(fgets(STDIN, 1024));
//dd( filter_var('https://vk.com', FILTER_VALIDATE_URL));
	dd($options);