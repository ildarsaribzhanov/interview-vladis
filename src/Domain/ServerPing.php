<?php

namespace App\Domain;


use App\Exceptions\UndefinedStatusException;
use DateTime;

/**
 * Пинг сервера
 *
 * Class ServerPing
 *
 * @package App\Domain
 */
class ServerPing
{
    /** @var int */
    private $id;

    /** @var int */
    private $server_id;

    /** @var string */
    private $status = 'wait';

    /** @var int */
    private $response_time = null;

    /** @var DateTime */
    private $date;


    /**
     * ServerPing constructor.
     *
     * @param int $id
     * @param int $server_id
     */
    public function __construct(int $id, int $server_id)
    {
        $this->id        = $id;
        $this->server_id = $server_id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $status
     *
     * @throws UndefinedStatusException
     */
    public function setStatus(string $status)
    {
        if (!in_array(strtolower($status), ['wait', 'fail', 'success'])) {
            throw new  UndefinedStatusException('Неизвестный статус');
        }

        $this->status = $status;
    }

    /**
     * Установка времени выполнения запроса
     *
     * @param int $microseconds
     */
    public function setResponseTime(int $microseconds)
    {
        $this->response_time = $microseconds;
    }

    /**
     * @return int
     */
    public function getResponseTime(): int
    {
        return $this->response_time;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getServerId(): int
    {
        return $this->server_id;
    }

    /**
     * Получить дату запроса
     */
    public function getDate()
    {
        return $this->date;
    }
}