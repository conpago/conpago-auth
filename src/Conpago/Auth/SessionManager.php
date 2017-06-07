<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 09.11.13
 * Time: 15:30
 */

namespace Conpago\Auth;

use Conpago\Auth\Contract\IAuthModel;
use Conpago\Auth\Contract\ISession;
use Conpago\Auth\Contract\ISessionManager;
use Conpago\Helpers\Contract\IAppPath;

class SessionManager implements ISessionManager
{
    const USER_LOGIN = 'userLogin';
    const USER = 'user';

    /** @var ISession */
    private $session;

    public function __construct(ISession $session, IAppPath $appPath)
    {
        $this->session = $session;
        $this->session->setSavePath($appPath->sessions());
    }

    /**
     * @param IAuthModel $authModel
     *
     * @return void
     *
     * @throws DisabledSessionsException
     */
    public function login(IAuthModel $authModel): void
    {
        $this->initialize();

        $this->session->register(self::USER_LOGIN, $authModel->getLogin());
        $this->session->register(self::USER, $authModel);
    }

    /**
     * @return bool
     *
     * @throws DisabledSessionsException
     */
    public function isLoggedIn(): bool
    {
        $this->initialize();

        return $this->session->isRegistered(self::USER_LOGIN);
    }

    /**
     * @return IAuthModel
     *
     * @throws DisabledSessionsException
     * @throws UserNotLoggedException
     */
    public function getCurrentUser(): IAuthModel
    {
        $this->initialize();

        if (!$this->isLoggedIn()) {
            throw new UserNotLoggedException();
        }

        return $this->session->getValue(self::USER);
    }

    /**
     * @throws DisabledSessionsException
     */
    private function initialize()
    {
        $sessionStatus = $this->session->getStatus();
        switch ($sessionStatus) {
            case PHP_SESSION_DISABLED:
                throw new DisabledSessionsException();
            case PHP_SESSION_ACTIVE:
                return;
            case PHP_SESSION_NONE:
                $this->session->start();
        }
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->initialize();

        $this->session->destroy();
    }
}
