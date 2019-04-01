<?php


namespace App\Storage\Contracts;


use Server;

/**
 * Контракт
 * Interface ServerStorage
 *
 * @package App\Storage
 */
interface ServerStorageContract
{
    /**
     * Поиск сервера по id
     *
     * @param int $id
     *
     * @return Server
     */
    public function findById(int $id): Server;

    /**
     * Выборка всех серверов
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Сохранить сервер
     *
     * @param Server $server
     *
     * @return bool
     */
    public function save(Server $server): bool;

    /**
     * Создание нового сервера
     *
     * @param int    $group_id
     * @param string $ip
     * @param string $comment
     *
     * @return Server
     */
    public function create(int $group_id, string $ip, string $comment = ''): Server;
}