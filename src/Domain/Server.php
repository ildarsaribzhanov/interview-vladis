<?php


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
}