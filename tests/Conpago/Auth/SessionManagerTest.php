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
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class SessionManagerTest extends TestCase
{
    /** @var ISession | MockObject */
    private $sessionMock;

    /** @var IAuthModel | MockObject */
    private $authModelMock;

    /** @var ISessionManager */
    private $sut;

    public function setUp()
    {
        $this->sessionMock = $this->createMock(ISession::class);
        $this->authModelMock = $this->createMock(IAuthModel::class);

        $appPath = $this->createMock(IAppPath::class);
        $appPath->expects($this->once())->method('sessions')->willReturn('');

        $this->sut = new SessionManager($this->sessionMock, $appPath);
    }

    public function testLogin()
    {
        $this->sessionMock->method('getStatus')->willReturn(PHP_SESSION_NONE);

        $dummyLogin = "dummyLogin";
        $this->authModelMock = $this->createMock(IAuthModel::class);
        $this->authModelMock->method('getLogin')->willReturn($dummyLogin);

        $this->sessionMock->expects($this->exactly(2))
            ->method('register')
            ->withConsecutive(
                    array(SessionManager::USER_LOGIN, $dummyLogin),
                    array(SessionManager::USER, $this->authModelMock)
                );

        $this->sut->login($this->authModelMock);
    }

    public function testLoginThrowsExceptionWhenDisabledSessions()
    {
        $this->authModelMock = $this->createMock(IAuthModel::class);
        $this->sessionMock->method('getStatus')->willReturn(PHP_SESSION_DISABLED);

        $this->expectException(DisabledSessionsException::class);

        $this->sut->login($this->authModelMock);
    }

    public function testLogout()
    {
        $this->sessionMock->method('getStatus')->willReturn(PHP_SESSION_NONE);

        $this->sessionMock->expects($this->once())
            ->method('destroy');

        $this->sut->logout();
    }

    public function testLogoutThrowsExceptionWhenDisabledSessions()
    {
        $this->sessionMock->method('getStatus')->willReturn(PHP_SESSION_DISABLED);

        $this->expectException(DisabledSessionsException::class);

        $this->sut->logout();
    }

    public function testIsLoggedIn()
    {
        $this->sessionMock->method('getStatus')->willReturn(PHP_SESSION_NONE);

        $this->sessionMock->expects($this->once())
            ->method('isRegistered')
            ->with(SessionManager::USER_LOGIN);

        $this->sut->isLoggedIn();
    }
    public function testIsLoggedInThrowsExceptionWhenDisabledSessions()
    {
        $this->sessionMock->method('getStatus')->willReturn(PHP_SESSION_DISABLED);

        $this->expectException(DisabledSessionsException::class);

        $this->sut->isLoggedIn();
    }

    public function testGetCurrentUserWhenLogged()
    {
        $dummyUser = $this->createMock(IAuthModel::class);
        $this->sessionMock->method('getStatus')->willReturn(PHP_SESSION_ACTIVE);

        $this->sessionMock
            ->method('isRegistered')
            ->willReturn(true);

        $this->sessionMock
            ->method('getValue')
            ->willReturn($dummyUser);

        $this->assertEquals($dummyUser, $this->sut->getCurrentUser());
    }

    public function testGetCurrentUserWhenNotLogged()
    {
        $this->sessionMock->method('getStatus')->willReturn(PHP_SESSION_NONE);

        $this->sessionMock
            ->method('isRegistered')
            ->willReturn(false);

        $this->sessionMock->expects($this->never())
            ->method('getValue');

        $this->expectException(UserNotLoggedException::class);

        $this->sut->getCurrentUser();
    }

    public function testGetCurrentUserThrowsExceptionWhenDisabledSessions()
    {
        $this->sessionMock->method('getStatus')->willReturn(PHP_SESSION_DISABLED);

        $this->expectException(DisabledSessionsException::class);

        $this->sut->getCurrentUser();
    }
}
