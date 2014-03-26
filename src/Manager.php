<?php namespace Inkwell\Event
{
	class Manager implements ManagerInterface
	{
		use Emitter;

		/**
		 * Trigger an event to be emitted
		 *
		 * This is a public proxy for the '::emit()' method.
		 *
		 * @see Emitter::emit()
		 */
		public function trigger($event, Array $data, EmitterInterface $context = NULL)
		{
			return $this->emit($event, $data, $context);
		}


		/**
		 * Watch another emitter for triggered events
		 *
		 * Events are immediately proxied to all the listeners registered with the Manager.
		 *
		 * @param EmitterInterface $emitter The emitter to watch
		 * @return void
		 */
		public function watch(EmitterInterface $emitter)
		{
			$emitter->on(NULL, [$this, 'trigger']);
		}
	}
}