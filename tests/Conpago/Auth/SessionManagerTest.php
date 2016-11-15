<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 29.06.14
	 * Time: 17:26
	 */

	namespace Conpago\Auth;

	use Conpago\Auth\Contract\IAuthModel;
	use Conpago\Auth\Contract\ISession;
	use Conpago\Auth\Contract\ISessionManager;
    use Conpago\Helpers\Contract\IAppPath;

    class SessionManagerTest extends \PHPUnit_Framework_TestCase
	{
		/**
		 * @var ISession
		 */
		private $session;

		/**
		 * @var IAuthModel
		 */
		private $authModel;

		/**
		 * @var ISessionManager
		 */
		private $sessionManager;

		function setup()
		{
			$this->session = $this->createMock(ISession::class);
			$this->authModel = $this->createMock(IAuthModel::class);
			$appPath = $this->createMock(IAppPath::class);
			$appPath->expects($this->once())->method('sessions')->willReturn('');
			$this->sessionManager = new SessionManager($this->session, $appPath);
		}

		function testLogin()
		{
			$this->session->expects($this->any())->method('getStatus')->willReturn(PHP_SESSION_NONE);

			$dummyLogin = "dummyLogin";
			$this->authModel = $this->createMock(IAuthModel::class);
			$this->authModel->expects($this->any())->method('getLogin')->willReturn($dummyLogin);

			$this->session->expects($this->exactly(2))
				->method('register')
				->withConsecutive(
						array(SessionManager::USER_LOGIN, $dummyLogin),
						array(SessionManager::USER, $this->authModel)
					);

			$this->sessionManager->login($this->authModel);
		}

		/**
		 * @expectedException \Exception
		 * @expectedExceptionMessage Sessions are disabled!
		 */
		function testLoginThrowsExceptionWhenDisabledSessions()
		{
			$this->authModel = $this->createMock(IAuthModel::class);
			$this->session->expects($this->any())->method('getStatus')->willReturn(PHP_SESSION_DISABLED);
			$this->sessionManager->login($this->authModel);
		}

		function testLogout()
		{
			$this->session->expects($this->any())->method('getStatus')->willReturn(PHP_SESSION_NONE);

			$this->session->expects($this->once())
				->method('destroy');

			$this->sessionManager->logout();
		}

		/**
		 * @expectedException \Exception
		 * @expectedExceptionMessage Sessions are disabled!
		 */
		function testLogoutThrowsExceptionWhenDisabledSessions()
		{
			$this->session->expects($this->any())->method('getStatus')->willReturn(PHP_SESSION_DISABLED);
			$this->sessionManager->logout();
		}

		function testIsLoggedIn()
		{
			$this->session->expects($this->any())->method('getStatus')->willReturn(PHP_SESSION_NONE);

			$this->session->expects($this->once())
				->method('isRegistered')
				->with(SessionManager::USER_LOGIN);

			$this->sessionManager->isLoggedIn();
		}

		/**
		 * @expectedException \Exception
		 * @expectedExceptionMessage Sessions are disabled!
		 */
		function testIsLoggedInThrowsExceptionWhenDisabledSessions()
		{
			$this->session->expects($this->any())->method('getStatus')->willReturn(PHP_SESSION_DISABLED);
			$this->sessionManager->isLoggedIn();
		}

		function testGetCurrentUserWhenLogged()
		{
			$dummyUser = new TestUser();
			$this->session->expects($this->any())->method('getStatus')->willReturn(PHP_SESSION_ACTIVE);

			$this->session->expects($this->any())
				->method('isRegistered')
				->willReturn(true);

			$this->session->expects($this->any())
				->method('getValue')
				->willReturn($dummyUser);

			$this->assertEquals($dummyUser, $this->sessionManager->getCurrentUser());
		}

		function testGetCurrentUserWhenNotLogged()
		{
			$this->session->expects($this->any())->method('getStatus')->willReturn(PHP_SESSION_NONE);

			$this->session->expects($this->any())
				->method('isRegistered')
				->willReturn(false);

			$this->session->expects($this->never())
				->method('getValue');

			$this->assertNull($this->sessionManager->getCurrentUser());
		}

		/**
		 * @expectedException \Exception
		 * @expectedExceptionMessage Sessions are disabled!
		 */
		function testGetCurrentUserThrowsExceptionWhenDisabledSessions()
		{
			$this->session->expects($this->any())->method('getStatus')->willReturn(PHP_SESSION_DISABLED);
			$this->sessionManager->getCurrentUser();
		}
	}

	class TestUser
	{

	}
