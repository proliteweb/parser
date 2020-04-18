<?php
	require 'vendor/autoload.php';
	require 'bootstrap/app.php';

//	dd($argv);

	try{
		$imageParser = new \App\Console\Commands\ParseImagesCommand();
		$imageParser->handle();
	} catch (\Throwable $error){
		dd(__METHOD__, $error);
		(new \App\Exceptions\Handler())->handle($error);
	}

//	dd(__METHOD__, $matches);
//	unset($argv[0]);
//dd(fgets(STDIN, 1024));
//dd( filter_var('https://vk.com', FILTER_VALIDATE_URL));
//	d($options);