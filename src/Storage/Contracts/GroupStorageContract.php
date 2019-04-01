<?php

namespace App\Storage\Contracts;


use App\Domain\ServerGroup;

interface GroupStorageContract
{
    /**
     * Поиск группы по id
     *
     * @param int $id
     *
     * @return ServerGroup
     */
    public function findById(int $id): ServerGroup;

    /**
     * Выборка всех групп
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Сохранить группу
     *
     * @param ServerGroup $server
     *
     * @return bool
     */
    public function save(ServerGroup $server): bool;

    /**
     * Создание новой группы
     *
     * @param int $title
     *
     * @return ServerGroup
     */
    public function create(int $title): ServerGroup;
}