<?php

	namespace App\Components\Events;

	use App\Contracts\Event;
	use App\Contracts\EventListener;
	use App\Events\Parser\ImagesSingleUrlExtractedEvent;
	use App\Events\Parser\LinksSingleUrlExtractedEvent;
	use App\Helpers\Arr;
	use App\Listeners\Parser\ImagesSingleUrlExtractedListener;
	use App\Listeners\Parser\LinksSingleUrlExtractedListener;

	class EventManager
	{
		protected static $listen = [
			ImagesSingleUrlExtractedEvent::class => [
				ImagesSingleUrlExtractedListener::class,
			],
			LinksSingleUrlExtractedEvent::class  => [
				LinksSingleUrlExtractedListener::class,
			],
		];

		private static function isEventRegistered(Event $event)
		{
			$key = get_class($event);
			return Arr::has(static::$listen, $key);
		}


		private static function getEventListeners(Event $event)
		{
			$key = get_class($event);
			return Arr::get(static::$listen, $key, []);
		}

		public static function fire(Event $event): void
		{
			if (static::isEventRegistered($event)) {
				foreach (self::getEventListeners($event) as $listenerClass) {
					/** @var $listener EventListener */
					try {
						($listener = new $listenerClass);
						$listener->handle($event);
					} catch (\Exception $e) {
					}
				}
			}
		}
	}