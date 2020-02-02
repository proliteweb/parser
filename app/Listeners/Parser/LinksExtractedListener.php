<?php

	namespace App\Listeners\Parser;


	use App\Contracts\Event;
	use App\Contracts\EventListener;
	use App\Events\Parser\LinksExtractedEvent;

	class LinksExtractedListener implements EventListener
	{

		private function checkEvent($event)
		{
			return $event instanceof LinksExtractedEvent;
		}

		public function handle(Event $event)
		{
			if (!$this->checkEvent($event)) {
				return null;
			}
			/** @var $event LinksExtractedEvent */

//			$links = $event->getLinks();
			//todo do something with images tags
		}
	}