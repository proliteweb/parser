<?php

	namespace App\Listeners\Parser;


	use App\Contracts\Event;
	use App\Contracts\EventListener;
	use App\Events\Parser\LinksSingleUrlExtractedEvent;

	class LinksSingleUrlExtractedListener implements EventListener
	{

		private function checkEvent($event): bool
		{
			return $event instanceof LinksSingleUrlExtractedEvent;
		}

		public function handle(Event $event): void
		{
			if (!$this->checkEvent($event)) {
				return;
			}
			/** @var $event LinksSingleUrlExtractedEvent */

//			$links = $event->getLinks();
			//todo do something with links
		}
	}