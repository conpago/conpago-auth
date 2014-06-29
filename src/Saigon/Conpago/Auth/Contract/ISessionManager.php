<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Auth\Contract;

	interface ISessionManager
	{
		/**
		 * @return bool
		 */
		function isLoggedIn();

		/**
		 * @param IAuthModel $authModel
		 */
		function login(IAuthModel $authModel);

		/**
		 * @return IAuthModel
		 */
		function getCurrentUser();

		/**
		 * @return void
		 */
		function logout();
	}