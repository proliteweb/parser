<?php

	namespace App\Listeners\Parser;


	use App\Contracts\EventListener;
	use App\Events\Parser\ImagesExtractedEvent;

	class ImagesExtractedListener implements EventListener
	{

		private function checkEvent($event)
		{
			return $event instanceof ImagesExtractedEvent;
		}

		public function handle($event)
		{
			if (!$this->checkEvent($event)) {
				return null;
			}
			//todo do something with images tags
		}
	}