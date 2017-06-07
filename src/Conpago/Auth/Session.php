<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 09.11.13
 * Time: 15:30
 */

namespace Conpago\Auth;

use Conpago\Auth\Contract\ISession;
use Conpago\Utils\SessionAccessor;

class Session implements ISession
{
    /** @var SessionAccessor */
    private $sessionAccessor;

    public function __construct(SessionAccessor $sessionAccessor)
    {
        $this->sessionAccessor = $sessionAccessor;
    }

    /**
     * @return bool
     */
    public function destroy(): bool
    {
        return session_destroy();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return session_id();
    }

    /**
     * @param string $sessionId
     *
     * @return void
     */
    public function setId(string $sessionId): void
    {
        session_id($sessionId);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return session_name();
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        session_name($name);
    }

    /**
     * @return bool
     */
    public function regenerateId(): bool
    {
        return session_regenerate_id(false);
    }

    /**
     * @return bool
     */
    public function regenerateIdAndRemoveOldSession(): bool
    {
        return session_regenerate_id(true);
    }

    /**
     * @return string
     */
    public function getSavePath(): string
    {
        return session_save_path();
    }

    /**
     * @param string $path
     *
     * @return void
     */
    public function setSavePath(string $path): void
    {
        session_save_path($path);
    }

    /**
     * @return bool
     */
    public function start(): bool
    {
        return session_start();
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return session_status();
    }

    /**
     * @return void
     */
    public function release(): void
    {
        session_unset();
    }

    /**
     * @return void
     */
    public function writeClose(): void
    {
        session_write_close();
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return void
     */
    public function register(string $name, $value): void
    {
        $this->sessionAccessor->setValue($name, $value);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function isRegistered(string $name): bool
    {
        return $this->sessionAccessor->contains($name);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getValue(string $name)
    {
        return $this->sessionAccessor->getValue($name);
    }
}
