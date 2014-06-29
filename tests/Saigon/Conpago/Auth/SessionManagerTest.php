<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 29.06.14
	 * Time: 17:26
	 */

	namespace Saigon\Conpago\Auth;

	class SessionManagerTest extends \PHPUnit_Framework_TestCase
	{
		private $session;

		private $authModel;

		private $sessionManager;

		function setup()
		{
			$this->session = $this->getMock('Saigon\Conpago\Auth\Contract\ISession');
			$this->authModel = $this->getMock('Saigon\Conpago\Auth\Contract\IAuthModel');
			$this->sessionManager = new SessionManager($this->session);
		}

		function testLogin()
		{
			$this->session->expects($this->any())->method('getStatus')->willReturn(PHP_SESSION_NONE);

			$dummyLogin = "dummyLogin";
			$this->authModel = $this->getMock('Saigon\Conpago\Auth\Contract\IAuthModel');
			$this->authModel->expects($this->any())->method('getLogin')->willReturn($dummyLogin);

			//$this->session->expects($this->once())->method('register')->with(SessionManager::USER, $this->authModel);
			$this->session->expects($this->once())->method('register')->with(SessionManager::USER_LOGIN, $dummyLogin);

			$this->sessionManager->login($this->authModel);
		}
	}