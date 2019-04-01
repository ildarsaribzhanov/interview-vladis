<?php


namespace App\Storage\Contracts;


use App\Domain\ServerPing;

/**
 * Interface PingStorageContract
 *
 * @package App\Storage\Contracts
 */
interface PingStorageContract
{
    /**
     * Поиск сервера по id
     *
     * @param int $id
     *
     * @return ServerPing
     */
    public function findById(int $id): ServerPing;

    /**
     * Выборка всех серверов
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Сохранить сервер
     *
     * @param ServerPing $ping
     *
     * @return bool
     */
    public function save(ServerPing $ping): bool;

    /**
     * Создание нового сервера
     *
     * @param int    $server_id
     * @param string $status
     * @param int    $response_time
     *
     * @return ServerPing
     */
    public function create(int $server_id, string $status = 'wait', int $response_time = 0): ServerPing;
}