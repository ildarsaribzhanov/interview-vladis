<?php


namespace App\Storage\Contracts;


use App\Domain\Server;

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
     * @return Server[]
     */
    public function getAll(): array;

    /**
     * Выборка всех серверов в группе
     *
     * @param int $group_id
     *
     * @return Server[]
     */
    public function getForGroup(int $group_id): array;

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