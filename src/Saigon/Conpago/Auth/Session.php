<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Auth;

	use Saigon\Conpago\Auth\Contract\ISession;
	use Saigon\Conpago\Utils\SessionAccessor;

	class Session implements ISession
	{
		/**
		 * @var SessionAccessor
		 */
		private $sessionAccessor;

		function __construct(SessionAccessor $sessionAccessor)
		{
			$this->sessionAccessor = $sessionAccessor;
		}

		/**
		 * @return bool
		 */
		public function destroy()
		{
			return session_destroy();
		}

		/**
		 * @return string
		 */
		public function getId()
		{
			return session_id();
		}

		/**
		 * @param string $sessionId
		 *
		 * @return void
		 */
		public function setId($sessionId)
		{
			session_id($sessionId);
		}

		/**
		 * @return string
		 */
		public function getName()
		{
			return session_name();
		}

		/**
		 * @param string $name
		 *
		 * @return void
		 */
		public function setName($name)
		{
			session_name($name);
		}

		/**
		 * @return bool
		 */
		public function regenerateId()
		{
			return session_regenerate_id(false);
		}

		/**
		 * @return bool
		 */
		public function regenerateIdAndRemoveOldSession()
		{
			return session_regenerate_id(true);
		}

		/**
		 * @return string
		 */
		public function getSavePath()
		{
			return session_save_path();
		}

		/**
		 * @param string $path
		 *
		 * @return void
		 */
		public function setSavePath($path)
		{
			session_save_path($path);
		}

		/**
		 * @return bool
		 */
		public function start()
		{
			return session_start();
		}

		/**
		 * @return int
		 */
		public function getStatus()
		{
			return session_status();
		}

		/**
		 * @return void
		 */
		public function release()
		{
			session_unset();
		}

		/**
		 * @return void
		 */
		public function writeClose()
		{
			session_write_close();
		}

		/**
		 * @param string $name
		 * @param mixed $value
		 *
		 * @return void
		 */
		public function register($name, $value)
		{
			$this->sessionAccessor->setValue($name, $value);
		}

		/**
		 * @param string $name
		 *
		 * @return bool
		 */
		public function isRegistered($name)
		{
			return $this->sessionAccessor->contains($name);
		}

		/**
		 * @param string $name
		 *
		 * @return mixed
		 */
		public function getValue($name)
		{
			return $this->sessionAccessor->getValue($name);
		}
	}