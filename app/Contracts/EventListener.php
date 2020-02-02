<?php

	namespace App\Contracts;

	interface EventListener
	{
		public function handle( $event);
	}