<?php namespace Inkwell\Event
{
	use Dotink\Flourish;

	/**
	 *
	 */
	trait Emitter
	{
		/**
		 * List of event listeners registered via ::on()
		 *
		 * @param array
		 */
		private $listeners = array();


		/**
		 * Emit an event to all listeners
		 *
		 * Callbacks will be passed matching parameters, with the exception of the `$context`.  If
		 * the `$context` is `NULL` then it will be replaced by the emitter on which the `::emit()`
		 * method was called.
		 *
		 * @param string $event The event to emit
		 * @param array $data Abitrary data to pass to listener, should be documented with events
		 * @param EmitterInterface $context Additional emitter context which can handle follow up events
		 * @return void
		 * @throws Flourish\ProgrammerException If `$event` is not a string
		 */
		protected function emit($event, Array $data, EmitterInterface $context = NULL)
		{
			if (!is_string($event) || !$event) {
				throw new Flourish\ProgrammerException(
					'Event must be a string and cannot be empty'
				);
			}

			if (!$context) {
				$context = $this;
			}

			if (isset($this->listeners[NULL])) {
				foreach ($this->listeners[NULL] as $callback) {
					$callback($event, $data, $context);
				}
			}

			if (isset($this->listeners[$event])) {
				foreach ($this->listeners[$event] as $callback) {
					$callback($event, $data, $context);
				}
			}
		}


		/**
		 * Register a listener for a given event
		 *
		 * The callback should receive the same parameters as the `::emit()` method.  If the
		 * `$event` is `NULL` the `$callback` will be triggered on any emitted event.
		 *
		 * @param string $event The event to listen for
		 * @param Callable $callback The callback to call when the event is emitted
		 * @return void
		 */
		public function on($event, Callable $callback)
		{
			if (!isset($this->listeners[$event])) {
				$this->listeners[$event] = array();
			}

			$this->listeners[$event][] = $callback;
		}
	}
}