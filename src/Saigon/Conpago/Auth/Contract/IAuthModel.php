<?php
	/**
	 * Created by PhpStorm.
	 * User: bartosz.golek
	 * Date: 20.12.13
	 * Time: 09:15
	 */

	namespace Saigon\Conpago\Auth\Contract;


	interface IAuthModel
	{

		/**
		 * @return string
		 */
		function getLogin();
	}