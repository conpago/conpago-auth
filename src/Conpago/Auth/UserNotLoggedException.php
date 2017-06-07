<?php
/**
 * Created by PhpStorm.
 * User: bg
 * Date: 07.06.17
 * Time: 21:23
 */

namespace Conpago\Auth;

use Exception;

class UserNotLoggedException extends Exception
{
    const USER_IS_NOT_LOGGED_IN = "User is not logged in!";

    public function __construct()
    {
        parent::__construct(self::USER_IS_NOT_LOGGED_IN);
    }
}
