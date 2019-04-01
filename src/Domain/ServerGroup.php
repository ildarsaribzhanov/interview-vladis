<?php

namespace App\Domain;


use App\Storage\Contracts\ServerStorageContract;

/**
 * Группа серверов
 *
 * Class ServerGroup
 *
 * @package App\Domain
 */
class ServerGroup
{

    /** @var int */
    private $id;

    /** @var string */
    private $title;


    /**
     * ServerGroup constructor.
     *
     * @param int    $id
     * @param string $title
     */
    public function __construct(int $id, string $title)
    {
        $this->id    = $id;
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param ServerStorageContract $serverStorage
     *
     * @return Server[]
     */
    public function getServers(ServerStorageContract $serverStorage): array
    {
        return $serverStorage->getForGroup($this->getId());
    }
}