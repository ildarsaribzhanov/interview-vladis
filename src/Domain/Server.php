<?php

namespace App\Domain;

use App\Storage\Contracts\PingStorageContract;

/**
 * Сервер
 *
 * Class Server
 */
class Server
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $group_id;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var
     */
    private $comment;

    /**
     * Servers constructor.
     *
     * @param int    $id
     * @param int    $group_id
     * @param string $ip
     */
    public function __construct(int $id, int $group_id, string $ip)
    {
        $this->id       = $id;
        $this->group_id = $group_id;
        $this->ip       = $ip;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->group_id;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param PingStorageContract $pingStorage
     *
     * @return ServerPing[]
     */
    public function getPings(PingStorageContract $pingStorage): array
    {
        return $pingStorage->getForServer($this->id);
    }
}