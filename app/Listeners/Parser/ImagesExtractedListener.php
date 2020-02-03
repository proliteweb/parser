<?php

	namespace App\Listeners\Parser;


	use App\Contracts\Event;
	use App\Contracts\EventListener;
	use App\Events\Parser\ImagesExtractedEvent;

	class ImagesExtractedListener implements EventListener
	{

		private function checkEvent($event): bool
		{
			return $event instanceof ImagesExtractedEvent;
		}

		public function handle(Event $event): void
		{
			if (!$this->checkEvent($event)) {
				return null;
			}
			/** @var $event ImagesExtractedEvent */
			//todo do something with images
		}
	}