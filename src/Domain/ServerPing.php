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
     * @param int      $id
     * @param int      $server_id
     * @param DateTime $date
     */
    public function __construct(int $id, int $server_id, DateTime $date)
    {
        $this->id        = $id;
        $this->server_id = $server_id;
        $this->date      = $date;
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
     * Установка даты запроса
     *
     * @param DateTime $dateTime
     */
    public function setDate(DateTime $dateTime)
    {
        $this->date = $dateTime;
    }
}