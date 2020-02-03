<?php

	namespace App\Listeners\Parser;


	use App\Contracts\Event;
	use App\Contracts\EventListener;
	use App\Events\Parser\LinksExtractedEvent;

	class LinksExtractedListener implements EventListener
	{

		private function checkEvent($event): bool
		{
			return $event instanceof LinksExtractedEvent;
		}

		public function handle(Event $event): void
		{
			if (!$this->checkEvent($event)) {
				return;
			}
			/** @var $event LinksExtractedEvent */

//			$links = $event->getLinks();
			//todo do something with links
		}
	}