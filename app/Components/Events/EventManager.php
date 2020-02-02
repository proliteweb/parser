<?php

	namespace App\Components\Events;

	use App\Contracts\Event;
	use App\Events\Parser\ImagesExtractedEvent;
	use App\Helpers\Arr;
	use App\Listeners\Parser\ImagesExtractedListener;

	class EventManager
	{
		protected static $listen = [
			ImagesExtractedEvent::class => [
				ImagesExtractedListener::class,
			],
		];

		public static function registerEvent(Event $event)
		{
			$key = get_class($event);
			static::$events[ $key ]['event'] = $event;
		}

		public static function registerListener(EventListener $listener)
		{

		}

		public static function fire(Event $event): void
		{
			$key = get_class($event);
			if (Arr::has(static::$listen, $key)) {
				foreach (Arr::get(static::$listen, $key) as $listenerClass) {
					/** @var $listener EventListener */
					try{
						($listener = new $listenerClass);
						$listener->handle($event);
					} catch (\Error $e){
						dd(__METHOD__, $e);
					}
				}
			}
		}
	}