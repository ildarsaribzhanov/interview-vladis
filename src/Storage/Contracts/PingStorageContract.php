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
     * @param ServerPing $server
     *
     * @return bool
     */
    public function save(ServerPing $server): bool;

    /**
     * Создание нового сервера
     *
     * @param int    $group_id
     * @param string $ip
     * @param string $comment
     *
     * @return ServerPing
     */
    public function create(int $group_id, string $ip, string $comment = ''): ServerPing;
}