<?php

	namespace App\Listeners\Parser;


	use App\Contracts\Event;
	use App\Contracts\EventListener;
	use App\Events\Parser\ImagesSingleUrlExtractedEvent;

	class ImagesSingleUrlExtractedListener implements EventListener
	{

		private function checkEvent($event): bool
		{
			return $event instanceof ImagesSingleUrlExtractedEvent;
		}

		public function handle(Event $event): void
		{
			if (!$this->checkEvent($event)) {
				return;
			}
			/** @var $event ImagesSingleUrlExtractedEvent */
			//todo do something with images
		}
	}