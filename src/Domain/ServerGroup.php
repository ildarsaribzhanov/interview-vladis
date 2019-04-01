<?php

namespace App\Domain;


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
}