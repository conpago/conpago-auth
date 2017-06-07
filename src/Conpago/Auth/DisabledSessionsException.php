<?php
/**
 * Created by PhpStorm.
 * User: bg
 * Date: 07.06.17
 * Time: 21:23
 */

namespace Conpago\Auth;

use Exception;

class DisabledSessionsException extends Exception
{
    const SESSIONS_ARE_DISABLED = 'Sessions are disabled!';

    public function __construct()
    {
        parent::__construct(self::SESSIONS_ARE_DISABLED);
    }
}
