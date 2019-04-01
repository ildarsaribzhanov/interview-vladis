<?php

namespace App\Domain;


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

    /** @var bool */
    private $success;

    /** @var int */
    private $response_time;

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
     * Установка успешного статуса
     */
    public function setSuccess()
    {
        $this->success = true;
    }


    /**
     *  Установка не успешногой статуса
     */
    public function setUnsuccess()
    {
        $this->success = false;
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